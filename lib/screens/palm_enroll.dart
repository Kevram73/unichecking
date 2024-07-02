import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:get/get.dart';

import '../controllers/CheckController.dart';
import '../helpers/coloors.dart';

class PalmEnroll extends StatelessWidget {
  PalmEnroll({super.key});

  final CheckController checkController = Get.put(CheckController());

  @override
  Widget build(BuildContext context) {
    Size size = MediaQuery.of(context).size;
    return Scaffold(
      appBar: AppBar(
        title: Text("Palm Enrollment", style: TextStyle(color: Colors.white),),
        centerTitle: true,
        backgroundColor: Coloors.primaryColor,
      ),

      body: SafeArea(child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        crossAxisAlignment: CrossAxisAlignment.center ,
        children: [

          const Text("Enrollment ..."),
          Padding(
            padding: const EdgeInsets.all(20.0),
            child: Center(
              child: Container(
                width: size.width/2,
                height: size.height/2,
                color: Colors.black,
                child: const AndroidView(
                    viewType: 'camera_view',
                    layoutDirection: TextDirection.ltr,
                    creationParams: <String, dynamic>{
                      "width": 500,
                      "height":500,
                    },
                    creationParamsCodec: StandardMessageCodec()
                ),
              ),
            ),
          ),
        ],
      ),),
    );
  }
}

