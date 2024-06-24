import 'dart:async';
import 'package:fluttertoast/fluttertoast.dart';
import 'package:get/get.dart';
import '../helpers/ZkPalmApiHelper.dart';
import '../screens/StatusScreen.dart';

class CheckController extends GetxController {
  var countdown = 5.obs;

  @override
  void onReady() {
    super.onReady();
    startCountdown();
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
    Get.offAll(() => const StatusScreen());
  }
}
