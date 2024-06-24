import 'package:flutter/material.dart';
import 'package:font_awesome_flutter/font_awesome_flutter.dart';
import 'package:get/get.dart';
import 'package:zktecopalm/screens/home.dart';

import '../helpers/coloors.dart';

class LogPalm extends StatelessWidget {
  const LogPalm({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        leading: null,
        title: const Text('Uni-Check'),
        centerTitle: true,
        backgroundColor: Coloors.primaryColor,
      ),
      floatingActionButton: FloatingActionButton(
        backgroundColor: Coloors.primaryColor,
        onPressed: (){

        },
        child: Icon(Icons.arrow_right),
      ),
      body: Container(
        decoration: BoxDecoration(
            color: Colors.white
        ),
        child: Column(
          children: [

            Center(
              child: Column(

                children: [
                  SizedBox(height: 30),
                  Container(decoration: BoxDecoration(color: Colors.white), child: Image.asset("assets/images/hand.webp", height: 200,)),
                  SizedBox(height: 30),
                  Text("Setup Palm recognition", style: TextStyle(fontSize: 30),),
                  Padding(
                    padding: const EdgeInsets.only(top: 12.0),
                    child: Text("Before starting, make sure your hand is clean and keep it for 5 secondes for recognition", style: TextStyle(fontSize: 16)),
                  ),

                  ElevatedButton(onPressed: (){
                    Get.off(Home());
                  }, style: ElevatedButton.styleFrom(backgroundColor: Colors.red),
                      child: Text('Annuler', style: TextStyle(fontSize: 20),))
                ],
              ),
            )
          ],
        ),
      ),
    );
  }
}