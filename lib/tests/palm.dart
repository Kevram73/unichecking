import 'package:flutter/material.dart';
import 'package:flutter/services.dart';

import '../helpers/ZkPalmApiHelper.dart';
 // Assurez-vous que le chemin est correct


class MyHomePage extends StatefulWidget {
  @override
  _MyHomePageState createState() => _MyHomePageState();
}

class _MyHomePageState extends State<MyHomePage> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text("ZK Palm API Example"),
      ),
      body: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: <Widget>[
            ElevatedButton(
              onPressed: () async {
                await ZKPalmApiHelper.checkStoragePermission();
              },
              child: Text("Check Storage Permission"),
            ),
            ElevatedButton(
              onPressed: () async {
                await ZKPalmApiHelper.tryGetUsbPermission();
              },
              child: Text("Get USB Permission"),
            ),
            ElevatedButton(
              onPressed: () async {
                await ZKPalmApiHelper.openDevice();
              },
              child: Text("Open Device"),
            ),
            ElevatedButton(
              onPressed: () async {
                await ZKPalmApiHelper.closeDevice();
              },
              child: Text("Close Device"),
            ),

            Container(
              width: 300,
              height: 300,
              color: Colors.black,
              child: AndroidView(
                viewType: 'camera_view',
                layoutDirection: TextDirection.ltr,
                creationParams: <String, dynamic>{},
                  creationParamsCodec: const StandardMessageCodec()
              ),
            ),
          ],
        ),
      ),
    );
  }
}
