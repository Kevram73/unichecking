import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:zktecopalm/screens/home.dart';
import 'package:zktecopalm/screens/palm_match.dart';

import '../helpers/coloors.dart';

class LogPalm extends StatelessWidget {
  const LogPalm({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        foregroundColor: Colors.white,
        leading: null,
        title: const Text('Uni-Check', style: TextStyle(color: Colors.white)),
        centerTitle: true,
        backgroundColor: Coloors.primaryColor,
      ),
      floatingActionButton: FloatingActionButton(
        backgroundColor: Coloors.primaryColor,
        onPressed: (){
          Get.to(PalmMatch());
        },
        child: const Icon(Icons.arrow_right),
      ),
      body: Container(
        decoration: const BoxDecoration(
            color: Colors.white
        ),
        child: Column(
          children: [

            Center(
              child: Column(

                children: [
                  const SizedBox(height: 30),
                  Container(decoration: const BoxDecoration(color: Colors.white), child: Image.asset("assets/images/hand.webp", height: 200,)),
                  const SizedBox(height: 30),
                  const Text("Setup Palm recognition", style: TextStyle(fontSize: 30),),
                  const Padding(
                    padding: EdgeInsets.only(top: 12.0),
                    child: Text("Before starting, make sure your hand is clean and keep it for 5 secondes for recognition", style: TextStyle(fontSize: 16)),
                  ),

                  ElevatedButton(onPressed: (){
                    Get.off(const Home());
                  }, style: ElevatedButton.styleFrom(backgroundColor: Colors.red),
                      child: const Text('Annuler', style: TextStyle(fontSize: 20),))
                ],
              ),
            )
          ],
        ),
      ),
    );
  }
}