import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:zktecopalm/screens/sign_nfc.dart';

import '../helpers/coloors.dart';

class MatriculeIn extends StatefulWidget {
  const MatriculeIn({super.key});

  @override
  State<MatriculeIn> createState() => _MatriculeInState();
}

class _MatriculeInState extends State<MatriculeIn> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text("UNI-CHECK"), centerTitle: true, backgroundColor: Coloors.primaryColor,),
      body: SingleChildScrollView(
        child: Padding(
          padding: const EdgeInsets.all(20.0),
          child: Column(
            children: [
              TextField(
                decoration: InputDecoration(
                  label: Text("Entrez votre matricule")
                ),
              ),
              SizedBox(height: 20),
              Container(child: ElevatedButton(onPressed: (){
                Get.to(SignNfc());
              }, style: ElevatedButton.styleFrom(backgroundColor: Coloors.primaryColor), child: Text('Enregistrer', style: TextStyle(fontSize: 20),)))
            ],
          ),
        ),
      ),
    );
  }
}
