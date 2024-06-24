
import 'package:get/get.dart';
import 'package:nfc_manager/nfc_manager.dart';
import 'package:zktecopalm/screens/log_palm.dart';

import '../screens/register_palm.dart';

class NfcController extends GetxController {
  var isAvailable = false.obs;
  var nfcStatus = "Tap an NFC tag to read the data".obs;

  @override
  void onInit() {
    super.onInit();
    checkNfcAvailability();
  }

  void checkNfcAvailability() async {
    bool available = await NfcManager.instance.isAvailable();
    isAvailable.value = available;
    if (!available) nfcStatus.value = "NFC is not available on this device";
  }

  void startNfcSession() {
    if (!isAvailable.value) {
      nfcStatus.value = "NFC is not available on this device";
      return;
    }

    NfcManager.instance.startSession(
      onDiscovered: (NfcTag tag) async {
        try {

          var ndef = Ndef.from(tag);
          if (ndef == null) {
            nfcStatus.value = "NFC tag is not NDEF formatted";
            return;
          }
          var records = tag.data['ndef']['identifier'];
          nfcStatus.value = "Data: $records";

          Get.to(const LogPalm());
        } catch (e) {
          nfcStatus.value = "Error reading NFC tag: s${e.toString()}";
        }
      },
    );
  }

  void startNfcSessionRegister() {
    if (!isAvailable.value) {
      nfcStatus.value = "NFC is not available on this device";
      return;
    }

    NfcManager.instance.startSession(
      onDiscovered: (NfcTag tag) async {
        try {

          var ndef = Ndef.from(tag);
          if (ndef == null) {
            nfcStatus.value = "NFC tag is not NDEF formatted";
            return;
          }
          var records = tag.data['ndef']['identifier'];
          nfcStatus.value = "Data: $records";

          Get.to(const RegisterPalm());
        } catch (e) {
          nfcStatus.value = "Error reading NFC tag: s${e.toString()}";
        }
      },
    );
  }

  void stopNfcSession() {
    NfcManager.instance.stopSession();
    nfcStatus.value = "NFC scanning stopped";
  }

  @override
  void onClose() {
    stopNfcSession();
    super.onClose();
  }
}
