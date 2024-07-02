import 'dart:async';
import 'package:fluttertoast/fluttertoast.dart';
import 'package:get/get.dart';

class MainController extends GetxController {
  var countdown = 5.obs;
  var isPressed = false;
  var isBegin = false;
  var isEnd = false;

  pressed(){
    isPressed = !isPressed;
  }

  begin(){

  }

  end(){

  }


}
