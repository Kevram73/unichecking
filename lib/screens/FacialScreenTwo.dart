import 'package:camera/camera.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import '../controllers/CustomCameraController.dart';
import '../helpers/coloors.dart';  // Correct the import path as needed

class FacialScreenTwo extends StatelessWidget {
  final CustomCameraController _controller = Get.put(CustomCameraController());

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
        onPressed: () {
          // Example: Navigate to another page or re-initialize camera etc.
          // Currently it navigates to the same page again, which might be incorrect.
        },
        child: const Icon(Icons.camera),
      ),
      body: Obx(() {
        if (_controller.isCameraInitialized.isTrue) {
          return buildCameraView();
        } else {
          return const Center(child: CircularProgressIndicator());
        }
      }),
    );
  }

  Widget buildCameraView() {
    return Container(
      decoration: const BoxDecoration(color: Colors.white),
      child: Column(
        children: [
          const Padding(
            padding: EdgeInsets.only(top: 12.0, left: 10),
            child: Text("Checkin", style: TextStyle(fontSize: 35, fontWeight: FontWeight.bold)),
          ),
          Padding(
            padding: const EdgeInsets.only(left: 12.0, top: 10),
            child: const Text("Take a picture", style: TextStyle(fontSize: 16)),
          ),
          Center(
            child: Column(
              children: [
                const SizedBox(height: 60),
                Container(
                  decoration: BoxDecoration(
                    shape: BoxShape.circle,
                    color: Colors.white,
                    border: Border.all(color: Coloors.primaryColor, width: 4)
                  ),
                  width: 300,
                  height: 300,
                  child: ClipOval(child: AspectRatio(aspectRatio: Get.width/Get.height, child: CameraPreview(_controller.cameraController! ))),
                ),
                const SizedBox(height: 30),
                const Text("Take a picture", style: TextStyle(fontSize: 30)),
                const Padding(
                  padding: EdgeInsets.only(top: 12.0),
                  child: Text("Your FACE ID will be added.", style: TextStyle(fontSize: 16)),
                )
              ],
            ),
          )
        ],
      ),
    );
  }
}
