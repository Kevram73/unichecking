import 'dart:async';
import 'package:get/get.dart';
import 'package:unichecking/screens/HomeScreen.dart';

class HomeController extends GetxController {
  @override
  void onReady() {
    super.onReady();
    Timer(Duration(seconds: 4), navigateToHome);
  }

  // This function can be modified to navigate to different pages based on your app's flow
  void navigateToHome() {
    Get.offAll(() => HomeScreen());
  }
}
