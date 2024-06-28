import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:sqflite_common_ffi/sqflite_ffi.dart';
import 'package:zktecopalm/screens/introscreen.dart';
import 'package:zktecopalm/screens/palm_enroll.dart';
import 'package:zktecopalm/tests/palm.dart';

void main() {
  sqfliteFfiInit();
  databaseFactory = databaseFactoryFfi;
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  // This widget is the root of your application.
  @override
  Widget build(BuildContext context) {
    return GetMaterialApp(
      title: 'UNI-CHECK',
      debugShowCheckedModeBanner: false,
      color: Colors.white,
      home: PalmEnroll(),
    );
  }
}
