import 'dart:async';
import 'package:get/get.dart';

import '../screens/home.dart';

class HomeController extends GetxController {
  @override
  void onReady() {
    super.onReady();
    Timer(const Duration(seconds: 1), navigateToHome);
  }

  // This function can be modified to navigate to different pages based on your app's flow
  void navigateToHome() {
    Get.offAll(() => Home());
  }
}