import 'package:flutter/material.dart';
import 'package:get/get.dart';

import '../controllers/HomeController.dart';
import '../helpers/coloors.dart';

class IntroScreen extends StatelessWidget {
  IntroScreen({Key? key}) : super(key: key);
  // Initialize the controller at the class level to avoid reinitializations
  final HomeController _controller = Get.put(HomeController());

  @override
  Widget build(BuildContext context) {
    // Listen to the controller's changes, if necessary
    return Scaffold(
      body: Center(

        child: Container(
          width: MediaQuery.of(context).size.width,
          decoration: const BoxDecoration(
            image: DecorationImage(
              opacity: 0.6,
              image: AssetImage('assets/images/UniCheck.webp'),
              fit: BoxFit.fill,
            ),
          ),
          child: const Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: <Widget>[
              Text(
                'UNI-CHECK',
                style: TextStyle(fontSize: 35, fontWeight: FontWeight.bold, color: Coloors.primaryColor),
              ),
              SizedBox(height: 20),
              SizedBox(
                width: 50,
                height: 50,
                child: CircularProgressIndicator(
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