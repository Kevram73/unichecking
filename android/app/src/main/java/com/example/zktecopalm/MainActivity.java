package com.example.zktecopalm;

import android.Manifest;
import android.annotation.SuppressLint;
import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.pm.PackageManager;
import android.graphics.Bitmap;
import android.graphics.Canvas;
import android.graphics.Color;
import android.graphics.Paint;
import android.hardware.usb.UsbDevice;
import android.util.Base64;
import android.view.SurfaceHolder;
import android.view.SurfaceView;
import android.view.View;
import android.view.ViewGroup;
import android.widget.EditText;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.core.app.ActivityCompat;
import androidx.core.content.ContextCompat;

import com.example.zktecopalm.ZKPalmUSBManager.ZKPalmUSBManager;
import com.example.zktecopalm.ZKPalmUSBManager.ZKPalmUSBManagerListener;
import com.zkteco.android.biometric.core.utils.LogHelper;
import com.zkteco.android.biometric.core.utils.ToolUtils;
import com.zkteco.android.biometric.easyapi.ZKPalmApi;
import com.zkteco.android.biometric.easyapi.ZKPalmApiListener;

import java.util.Arrays;

import io.flutter.embedding.android.FlutterActivity;
import io.flutter.embedding.engine.FlutterEngine;
import io.flutter.plugin.common.MethodChannel;
import io.flutter.plugin.common.StandardMessageCodec;
import io.flutter.plugin.platform.PlatformView;
import io.flutter.plugin.platform.PlatformViewFactory;

public class MainActivity extends FlutterActivity {
    private static final String CHANNEL = "com.example.zktecopalm/palmengine";
    private ZKPalmApi zkPalmApi = new ZKPalmApi();
    private final static int VID_ZKTECO   =   6997;
    private final static int PID_PAR200   =   1792;
    private ZKPalmUSBManager zkPalmUSBManager = null;
    private final static int ENROLL_CNT = 5;
    private final static int IDENTIFY_THRESOLD = 576;
    private boolean bstart = false;

    private int[] palmRect = new int[8];
    private String result = "";
    private TextView textView = null;
    private SurfaceView surfaceView = null;
    private EditText editText = null;
    private String regId = "";

    private DBManager dbManager = new DBManager();

    @Override
    public void configureFlutterEngine(@NonNull FlutterEngine flutterEngine) {
        super.configureFlutterEngine(flutterEngine);
        flutterEngine.getPlatformViewsController().getRegistry().registerViewFactory("camera_view", new SurfaceViewFactory());
        new MethodChannel(flutterEngine.getDartExecutor().getBinaryMessenger(), CHANNEL)
                .setMethodCallHandler(
                        (call, result) -> {
                            switch (call.method) {
                                case "checkStoragePermission":
                                    checkStoragePermission();
                                    result.success("Check Storage Permission");
                                    break;
                                case "tryGetUsbPermission":
                                    tryGetUSBPermission();
                                    result.success("Get USB Permission ...");
                                    break;
                                case "openDevice":
                                    openDevice();
                                    result.success("Open device ...");
                                    break;
                                case "closeDevice":
                                    closeDevice();
                                    result.success("Close device ...");
                                    break;
                                case "enroll":
                                    OnBnEnroll();
                                    result.success("Enroll ...");
                                    break;
                                case "onverify":
                                    OnBnVerify();
                                    result.success("Verify ...");
                                    break;
                                case "onclear":
                                    OnBnClear();
                                    result.success("Clear ...");
                                    break;
                                case "ondelete":
                                    OnBnDel();
                                    result.success("Delete ...");
                                    break;

                                default:
                                    result.notImplemented();
                                    break;
                            }
                        }
                );
    }

    public void setResult(String value){
        this.result = value;
    }

    private ZKPalmUSBManagerListener zkPalmUSBManagerListener = new ZKPalmUSBManagerListener(){
        public void onCheckPermission(int result) {
            LogHelper.d("ZKPalmUSBManagerListener onCheckPermission result" + result);
            if (0 == result)
            {
                afterGetUsbPermission();
            }
            else
            {
                setResult("init usb-permission failed, ret" + result);
            }
        }

        @Override
        public void onUSBArrived(UsbDevice device) {
            LogHelper.d("ZKPalmUSBManagerListener usb-arrived, usb" + device.toString());
            if (device.getVendorId() == VID_ZKTECO && device.getProductId() == PID_PAR200) {
                closeDevice();
                tryGetUSBPermission();
            }
        }

        @Override
        public void onUSBRemoved(UsbDevice device) {
            LogHelper.d("ZKPalmUSBManagerListener usb-removed, usb" + device.toString());
            if (device.getVendorId() == VID_ZKTECO && device.getProductId() == PID_PAR200) {
                closeDevice();
            }
        }
    };

    private void checkStoragePermission()
    {
        if (ContextCompat.checkSelfPermission(this.getApplicationContext(), Manifest.permission.READ_EXTERNAL_STORAGE)
                != PackageManager.PERMISSION_GRANTED) {
            ActivityCompat.requestPermissions(this, new String[]{Manifest.permission.READ_EXTERNAL_STORAGE}, 8);
        }
        if (ContextCompat.checkSelfPermission(this.getApplicationContext(), Manifest.permission.WRITE_EXTERNAL_STORAGE)
                != PackageManager.PERMISSION_GRANTED) {
            ActivityCompat.requestPermissions(this, new String[]{Manifest.permission.WRITE_EXTERNAL_STORAGE}, 8);
        }
    }

    private void tryGetUSBPermission()
    {
        zkPalmUSBManager.initUSBPermission();
    }


    private void afterGetUsbPermission()
    {
        openDevice();
    }

    private void openDevice()
    {
        int retVal = zkPalmApi.initalize(this.getApplicationContext(), VID_ZKTECO, PID_PAR200);
        if (0 != retVal)
        {
            setResult("start capture failed, ret=" + retVal);
            return;
        }
        final ZKPalmApiListener listener = new ZKPalmApiListener() {
            @Override
            public void onCapture(int actionResult, byte[] palmImage) {
                if (0 == actionResult) {
                    final int width = zkPalmApi.getImageWidth();
                    final int height = zkPalmApi.getImageHeight();
                    Bitmap bitmapPalm = ToolUtils.renderCroppedGreyScaleBitmap(palmImage, width, height);
                    doDraw(surfaceView, bitmapPalm);
                } else {
                    //échec ne fait rien
                }
            }

            @Override
            public void onException() {
                LogHelper.e("deviceException");
                zkPalmApi.resetEx();
            }

            @Override
            public void onMatch(int actionResult, byte[] verTemplate) {
                if (0 == actionResult)
                {
                    String[] idRet = new String[1];
                    int retVal = zkPalmApi.dbIdentify(verTemplate, idRet);
                    if (retVal >= IDENTIFY_THRESOLD) {
                        setResult("identify succ, userid:" + idRet[0] + ", score:" + retVal);
                    } else {
                        setResult("identify fail, score=" + retVal);
                    }
                }
                else
                {
                    // ne fait rien
                }
            }



            @Override
            public void onEnroll(int actionResult, int times, byte[] verTemplate, byte[] regTemplate) {
                int retVal = 0;
                if (0 == actionResult)
                {
                    String[] idRet = new String[1];
                    retVal = zkPalmApi.dbIdentify(verTemplate, idRet);
                    if (retVal >= IDENTIFY_THRESOLD)
                    {
                        setResult("the palm already enroll by " + idRet[0] + ",cancel enroll");
                        zkPalmApi.cancelEnroll();
                    }
                    else
                    {
                        setResult("We need to capture " + (ENROLL_CNT - times) + "times the plam template");
                    }
                }
                else if (1 == actionResult)
                {
                    retVal = zkPalmApi.dbAdd(regId, regTemplate);
                    if (0 == retVal)
                    {
                        String strFeature = Base64.encodeToString(regTemplate, Base64.NO_WRAP);
                        dbManager.insertUser(regId, strFeature);
                        setResult("enroll succ， retVal=" + retVal);
                    }
                    else
                    {
                        setResult("enroll fail, ret=" + retVal);
                    }
                }
                else
                {
                    setResult("enroll failed, ret=" + actionResult);
                }
            }


            @Override
            public void onFeatureInfo(int actionResult, int imageQuality, int templateQuality, int[] rect) {
                if (0 == actionResult)
                {
                    System.arraycopy(rect, 0, palmRect, 0, rect.length);
                }
                else
                {
                    Arrays.fill(palmRect, 0x0);
                }
            }
        };
        zkPalmApi.setZKPalmApiListener(listener);
        zkPalmApi.startCapture();

        setResult("start capture succ");
    }

    public void OnBnBegin(View view) {
        if (bstart) return;
        tryGetUSBPermission();
    }

    private void closeDevice()
    {
        LogHelper.d("close device");
        if (bstart) {
            zkPalmApi.stopCapture();
            bstart = false;
            zkPalmApi.unInitialize();
        }
    }

    public void OnBnStop()
    {
        if (bstart)
        {
            closeDevice();
            textView.setText("stop capture succ");
        }
        else
        {
            textView.setText("already stop");
        }
    }

    public void OnBnEnroll() {
        if (bstart) {
            regId = editText.getText().toString();
            if (regId.isEmpty())
            {
                LogHelper.d("please input your plamid");
                return;
            }
            if (dbManager.isPalmExited(regId))
            {
                LogHelper.d("the palm[" + regId + "] had registered!");
                return;
            }
            zkPalmApi.startEnroll();
            LogHelper.d("You need to put your palm 5 times above the sensor");
        }
        else
        {
            LogHelper.d("please begin capture first");
        }
    }

    @SuppressLint("SetTextI18n")
    public void OnBnVerify() {
        if (bstart) {
            zkPalmApi.cancelEnroll();
        }else {
            textView.setText("please begin capture first");
        }
    }

    public void OnBnDel()
    {
        if (bstart) {
            regId = editText.getText().toString();
            if (null == regId || regId.isEmpty())
            {
                textView.setText("please input your plamid");
                return;
            }
            if (!dbManager.isPalmExited(regId))
            {
                textView.setText("the plam no registered");
                return;
            }
            new  AlertDialog.Builder(this)
                    .setTitle("do you want to delete the plam?" )
                    .setIcon(android.R.drawable.ic_dialog_info)
                    .setPositiveButton("yes", new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialog, int which) {
                            if (dbManager.deleteUser(regId))
                            {
                                zkPalmApi.dbDel(regId);
                                setResult("delete success！");
                            }
                            else {
                                setResult("Open db fail！");
                            }
                        }
                    })
                    .setNegativeButton("no", new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialog, int which) {

                        }
                    })
                    .show();
        }
    }

    public void OnBnClear()
    {
        if (bstart) {
            new  AlertDialog.Builder(this)
                    .setTitle("do you want to delete all the plam?" )
                    .setIcon(android.R.drawable.ic_dialog_info)
                    .setPositiveButton("yes", new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialog, int which) {
                            if (dbManager.clear())
                            {
                                zkPalmApi.dbClear();
                                setResult("Clear success！");
                            }
                            else {
                                setResult("Open db fail！");
                            }
                        }
                    })
                    .setNegativeButton("no", new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialog, int which) {

                        }
                    })
                    .show();
        }
    }

    private void doDraw(SurfaceView surfaceView, Bitmap bitmap) {
        SurfaceHolder holder = surfaceView.getHolder();
        if (null == holder) {
            return;
        }
        Canvas canvas = holder.lockCanvas();
        if (null == canvas) {
            return;
        }
        Paint painter = new Paint();
        painter.setStyle(Paint.Style.FILL);
        painter.setAntiAlias(true);
        painter.setFilterBitmap(true);
        canvas.drawBitmap(bitmap, 0, 0, painter);
        drawFaceRectCorner(canvas, palmRect);
        holder.unlockCanvasAndPost(canvas);
    }

    private void drawFaceRectCorner(Canvas canvas, int[] rect) {
        Paint mFacePaint = new Paint(Paint.ANTI_ALIAS_FLAG);
        mFacePaint.setStrokeWidth(4);
        mFacePaint.setStyle(Paint.Style.STROKE);
        mFacePaint.setColor(Color.GREEN);

        canvas.drawLine(rect[0], rect[1], rect[2], rect[3], mFacePaint);
        canvas.drawLine(rect[2], rect[3], rect[4], rect[5], mFacePaint);
        canvas.drawLine(rect[4], rect[5], rect[6], rect[7], mFacePaint);
        canvas.drawLine(rect[6], rect[7], rect[0], rect[1], mFacePaint);
    }

    class SurfaceViewFactory extends PlatformViewFactory {
        SurfaceViewFactory() {
            super(StandardMessageCodec.INSTANCE);
        }

        @Override
        public PlatformView create(Context context, int id, @Nullable Object args) {
            surfaceView = new SurfaceView(context);
            surfaceView.setLayoutParams(new ViewGroup.LayoutParams(ViewGroup.LayoutParams.MATCH_PARENT, ViewGroup.LayoutParams.MATCH_PARENT));
            return new SurfaceViewPlatformView(surfaceView);
        }

    }

    class SurfaceViewPlatformView implements PlatformView {
        private final SurfaceView surfaceView;

        SurfaceViewPlatformView(SurfaceView surfaceView) {
            this.surfaceView = surfaceView;
        }

        @Override
        public View getView() {
            return surfaceView;
        }

        @Override
        public void dispose() {
        }
    }
}
