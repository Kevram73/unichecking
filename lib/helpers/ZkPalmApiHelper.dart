import 'package:flutter/services.dart';

class ZKPalmApiHelper {
  static const MethodChannel _channel = MethodChannel('com.example.zktecopalm/palmengine');

  static Future<void> checkStoragePermission() async {
    try {
      final result = await _channel.invokeMethod('checkStoragePermission');
      print(result);
    } on PlatformException catch (e) {
      print("Failed to check storage permission: '${e.message}'.");
    }
  }

  static Future<void> tryGetUsbPermission() async {
    try {
      final result = await _channel.invokeMethod('tryGetUsbPermission');
      print(result);
    } on PlatformException catch (e) {
      print("Failed to get USB permission: '${e.message}'.");
    }
  }

  static Future<void> openDevice() async {
    try {
      final result = await _channel.invokeMethod('openDevice');
      print(result);
    } on PlatformException catch (e) {
      print("Failed to open device: '${e.message}'.");
    }
  }

  static Future<void> closeDevice() async {
    try {
      final result = await _channel.invokeMethod('closeDevice');
      print(result);
    } on PlatformException catch (e) {
      print("Failed to close device: '${e.message}'.");
    }
  }
}
