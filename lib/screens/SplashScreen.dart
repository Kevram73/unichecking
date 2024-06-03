import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:unichecking/helpers/coloors.dart';

import '../controllers/HomeController.dart';

class SplashScreen extends StatelessWidget {
  SplashScreen({Key? key}) : super(key: key);
  // Initialize the controller at the class level to avoid reinitializations
  final HomeController _controller = Get.put(HomeController());

  @override
  Widget build(BuildContext context) {
    // Listen to the controller's changes, if necessary
    return Scaffold(
      body: Center(

        child: Container(
          width: MediaQuery.of(context).size.width,
          decoration: BoxDecoration(
            image: DecorationImage(
              opacity: 0.6,
              image: AssetImage('assets/images/UniCheck.webp'),
              fit: BoxFit.fill,
            ),
          ),
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: <Widget>[
              Text(
                'UNI-CHECK',
                style: TextStyle(fontSize: 35, fontWeight: FontWeight.bold, color: Coloors.primaryColor),
              ),
              SizedBox(height: 20),
              Container(
                width: 50,
                height: 50,
                child: const CircularProgressIndicator(
                  color: Coloors.primaryColor,
                ),
              ),  // Visual feedback for loading
              SizedBox(height: 20),
              Text('Chargement...', style: TextStyle(fontSize: 18),)
            ],
          ),
        ),
      ),
    );
  }
}
