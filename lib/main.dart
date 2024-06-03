import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:unichecking/screens/SplashScreen.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});


  @override
  Widget build(BuildContext context) {
    return GetMaterialApp(
      title: 'Uni-Check',
      debugShowCheckedModeBanner: false,
      home: SplashScreen(),
    );
  }
}

