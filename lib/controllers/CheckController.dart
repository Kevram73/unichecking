import 'dart:async';
import 'package:fluttertoast/fluttertoast.dart';
import 'package:get/get.dart';
import '../helpers/ZkPalmApiHelper.dart';
import '../screens/StatusScreen.dart';

class CheckController extends GetxController {
  var countdown = 5.obs;

  @override
  void onReady() async{
    super.onReady();
    await ZKPalmApiHelper.checkStoragePermission();
    await ZKPalmApiHelper.tryGetUsbPermission();
    await ZKPalmApiHelper.openDevice();
    
    //await ZKPalmApiHelper.enroll();
    // startCountdown();
  }

  // Start the countdown timer and show toast messages
  void startCountdown() {
    Timer.periodic(const Duration(seconds: 1), (timer) {
      if (countdown.value == 0) {
        timer.cancel();
        navigateToHome();
      } else {
        Fluttertoast.showToast(
          msg: 'Switching in ${countdown.value} seconds',
          toastLength: Toast.LENGTH_SHORT,
          gravity: ToastGravity.BOTTOM,
        );
        countdown.value--;
      }
    });
  }

  // Navigate to the home screen
  void navigateToHome() async {
    await ZKPalmApiHelper.closeDevice();
    Get.to(() => const StatusScreen());
  }
}
