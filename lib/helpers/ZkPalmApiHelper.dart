import 'dart:collection';

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

  static Future users() async {
    try {
      final result = await _channel.invokeMethod('users');
      return result;
    } on PlatformException catch (e) {
      return {"error": "Failed to get users list: '${e.message}'"};
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

  static Future<void> enroll() async {
    try {
      final result = await _channel.invokeMethod('enroll');
      print(result);
    } on PlatformException catch (e) {
      print("Failed to enroll: '${e.message}'.");
    }
  }

  static Future<void> verify() async {
    try {
      final result = await _channel.invokeMethod('onverify');
      print(result);
    } on PlatformException catch (e) {
      print("Failed to verify: '${e.message}'.");
    }
  }

  static Future<void> clear() async {
    try {
      final result = await _channel.invokeMethod('onclear');
      print(result);
    } on PlatformException catch (e) {
      print("Failed to clear data: '${e.message}'.");
    }
  }

  static Future<void> delete() async {
    try {
      final result = await _channel.invokeMethod('ondelete');
      print(result);
    } on PlatformException catch (e) {
      print("Failed to delete: '${e.message}'.");
    }
  }
}
