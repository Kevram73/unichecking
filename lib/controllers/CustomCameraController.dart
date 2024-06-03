import 'package:camera/camera.dart';
import 'package:get/get.dart';

class CustomCameraController extends GetxController {
  // Use non-nullable type as we ensure initialization in onInit
  final cameras = <CameraDescription>[].obs;
  CameraController? cameraController;
  final isCameraInitialized = false.obs;

  @override
  void onInit() {
    super.onInit();
    _initializeCameras();
  }

  void _initializeCameras() async {
    try {
      final List<CameraDescription> availableCams = await availableCameras();
      if (availableCams.isNotEmpty) {
        cameras.value = availableCams;
        _initializeCamera(availableCams.last);
      }
    } catch (e) {
      print('Error initializing cameras: $e');
    }
  }

  void _initializeCamera(CameraDescription cameraDescription) async {
    cameraController = CameraController(
      cameraDescription,
      ResolutionPreset.max,
      enableAudio: false,
    );

    try {
      await cameraController!.initialize();
      isCameraInitialized.value = true;
      update(); // This method from GetX is used to update the UI
    } catch (e) {
      print('Error initializing camera: $e');
    }
  }

  void switchCamera(CameraDescription cameraDescription) async {
    if (isCameraInitialized.value) {
      await cameraController!.dispose();
      _initializeCamera(cameraDescription);
    }
  }

  @override
  void onClose() {
    super.onClose();
    if (isCameraInitialized.value) {
      cameraController!.dispose();
    }
  }
}
