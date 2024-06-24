import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:get/get.dart';
import 'package:zktecopalm/helpers/coloors.dart';

import '../controllers/CheckController.dart';



class PalmMatch extends StatelessWidget {
  PalmMatch({super.key});
  // final CheckController checkController = Get.put(CheckController());

    @override
    Widget build(BuildContext context) {
      Size size = MediaQuery.of(context).size;
      return Scaffold(
        appBar: AppBar(
          title: const Text("Palm Matching", style: TextStyle(color: Colors.white)),
          centerTitle: true,
          backgroundColor: Coloors.primaryColor,
        ),

        body: SafeArea(child: Column(
          children: [
            const Text("Matching ..."),
            Padding(
              padding: const EdgeInsets.all(20.0),
              child: Container(
                width: size.width/2,
                height: size.height/2,
                color: Colors.black,
                child: AndroidView(
                    viewType: 'camera_view',
                    layoutDirection: TextDirection.ltr,
                    creationParams: <String, dynamic>{},
                    creationParamsCodec: const StandardMessageCodec()
                ),
              ),
            ),
          ],
        ),),
      );
    }

}

