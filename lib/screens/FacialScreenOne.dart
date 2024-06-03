import 'package:flutter/material.dart';
import 'package:font_awesome_flutter/font_awesome_flutter.dart';
import 'package:get/get.dart';
import 'package:unichecking/helpers/coloors.dart';
import 'package:unichecking/screens/FacialScreenTwo.dart';

class FacialScreenOne extends StatelessWidget {
  const FacialScreenOne({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
          title: const Text('Uni-Check'),
          centerTitle: true,
        backgroundColor: Coloors.primaryColor,
      ),
      floatingActionButton: FloatingActionButton(
        backgroundColor: Coloors.primaryColor,
        onPressed: (){
          Get.to(FacialScreenTwo());
        },
        child: Icon(Icons.arrow_right),
      ),
      body: Container(
        decoration: BoxDecoration(
          color: Colors.white
        ),
        child: Column(
          children: [
            Row(
              children: [
                Padding(
                  padding: const EdgeInsets.only(top: 12.0, left: 10),
                  child: Text("Checkin", style: TextStyle(fontSize: 35, fontWeight: FontWeight.bold)),
                ),
              ],
            ),
            Row(
              children: [
                Padding(
                  padding: const EdgeInsets.only(left: 12.0, top: 10),
                  child: Text("Face ID", style: TextStyle(fontSize: 16)),
                ),
              ],
            ),
            Center(
              child: Column(

                children: [
                  SizedBox(height: 30),
                  Image.asset("assets/images/face-scan.webp"),
                  SizedBox(height: 30),
                  Text("Setup Face Recognition", style: TextStyle(fontSize: 30),),
                  Padding(
                    padding: const EdgeInsets.only(top: 12.0),
                    child: Text("Before starting, make sure the camera is clean.", style: TextStyle(fontSize: 16)),
                  )
                ],
              ),
            )
          ],
        ),
      ),
    );
  }
}
