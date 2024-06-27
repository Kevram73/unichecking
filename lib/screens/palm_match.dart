import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:get/get.dart';
import 'package:zktecopalm/helpers/coloors.dart';
import 'package:fluttertoast/fluttertoast.dart';

import '../controllers/CheckController.dart';
import '../helpers/ZkPalmApiHelper.dart';

class PalmMatch extends StatelessWidget {
  TextEditingController idController = TextEditingController(text: "scar");

  void showToast(String message) {
    Fluttertoast.showToast(
        msg: message,
        toastLength: Toast.LENGTH_SHORT,
        gravity: ToastGravity.BOTTOM,
        timeInSecForIosWeb: 1,
        backgroundColor: Colors.red,
        textColor: Colors.white,
        fontSize: 16.0
    );
  }

  void onBegin() {
    ZKPalmApiHelper.openDevice().then((_) {
      showToast("Capture started...");
    }).catchError((error) {
      showToast("Failed to start capture: $error");
    });
  }

  void onEnd() {
    ZKPalmApiHelper.closeDevice().then((_) {
      showToast("Capture ended...");
    }).catchError((error) {
      showToast("Failed to end capture: $error");
    });
  }

  void onEnroll() {
    ZKPalmApiHelper.enroll().then((_) {
      showToast("Enrollment started...");
    }).catchError((error) {
      showToast("Failed to enroll: $error");
    });
  }

  void onIdentify() {
    ZKPalmApiHelper.verify().then((_) {
      showToast("Identification started...");
    }).catchError((error) {
      showToast("Failed to identify: $error");
    });
  }

  void onDelete() {
    ZKPalmApiHelper.delete().then((_) {
      showToast("Deletion completed...");
    }).catchError((error) {
      showToast("Failed to delete: $error");
    });
  }

  void onClear() {
    ZKPalmApiHelper.clear().then((_) {
      showToast("Cleared all data...");
    }).catchError((error) {
      showToast("Failed to clear data: $error");
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text("Palm Matching", style: TextStyle(color: Colors.white)),
        centerTitle: true,
        backgroundColor: Coloors.primaryColor,
      ),
      body: SingleChildScrollView(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: <Widget>[
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceEvenly,
              children: <Widget>[
                ElevatedButton(onPressed: onBegin, child: Text("Begin")),
                ElevatedButton(onPressed: onEnd, child: Text("End")),
                ElevatedButton(onPressed: onEnroll, child: Text("Enroll")),
                ElevatedButton(onPressed: onIdentify, child: Text("Identify")),
              ],
            ),
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceEvenly,
              children: <Widget>[
                ElevatedButton(onPressed: onDelete, child: Text("Delete")),
                ElevatedButton(onPressed: onClear, child: Text("Clear")),
                Text("ID:"),
                Expanded(
                  child: TextField(
                    controller: idController,
                    decoration: InputDecoration(hintText: "Enter ID"),
                  ),
                ),
              ],
            ),
            Container(
              padding: EdgeInsets.all(8.0),
              width: double.infinity,
              height: 200,
              child: const AndroidView(
                  viewType: 'camera_view',
                  layoutDirection: TextDirection.ltr,
                  creationParams: <String, dynamic>{
                    "width": 500,
                    "height":500,
                  },
                  creationParamsCodec: StandardMessageCodec()
              ), // Placeholder for SurfaceView or similar
            ),
          ],
        ),
      ),
    );
  }
}
