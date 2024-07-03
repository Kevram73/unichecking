import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:zktecopalm/screens/palm_enroll.dart';
import 'package:zktecopalm/screens/register_palm.dart';
import '../controllers/NfcController.dart';
import '../helpers/coloors.dart';// Adjust the import according to your file structure

class SignNfc extends StatelessWidget {
  const SignNfc({super.key});

  @override
  Widget build(BuildContext context) {
    final NfcController nfcController = Get.put(NfcController());

    return Scaffold(
      appBar: AppBar(
        foregroundColor: Colors.white,
        leading: const Icon(Icons.home),
        title: const Text('Uni-Check'),
        centerTitle: true,
        backgroundColor: Coloors.primaryColor, // Assume your primaryColor is blue
      ),
      body: Container(
        alignment: Alignment.center,
        padding: const EdgeInsets.all(16),
        child: Obx(() => Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Image.asset("assets/images/Nfc.png"),
            const SizedBox(height: 20),
            const Text("Setup NFC Reader", style: TextStyle(fontSize: 30)),
            Padding(
              padding: const EdgeInsets.only(top: 12.0),
              child: Text(nfcController.nfcStatus.value, textAlign: TextAlign.center),
            ),
            Row(
              mainAxisAlignment: MainAxisAlignment.center,
              crossAxisAlignment: CrossAxisAlignment.center,
              children: [
                ElevatedButton(
                  style: ElevatedButton.styleFrom(backgroundColor: Colors.red),
                  onPressed: (){
                    Get.back();
                  },
                  child: const Text("Annuler"),
                ),
                const SizedBox(width: 10),
                ElevatedButton(
                  // onPressed: nfcController.isAvailable.value
                  //     ? nfcController.startNfcSessionRegister
                  //     : null,
                  onPressed:(){
                    Get.to(const RegisterPalm());
                  } ,
                  child: nfcController.isAvailable.value
                      ? const Text("Start NFC Scan"): const Text("En écoute"),
                ),
              ],
            )
          ],
        )),
      ),
    );
  }
}
