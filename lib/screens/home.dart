import 'package:flutter/material.dart';
import 'package:font_awesome_flutter/font_awesome_flutter.dart';
import 'package:get/get.dart';
import 'package:zktecopalm/screens/admin/users.dart';
import 'package:zktecopalm/screens/in_nfc.dart';
import 'package:zktecopalm/screens/matricule_in.dart';

import '../helpers/coloors.dart';

class Home extends StatelessWidget {
  const Home({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Uni-Check', style: TextStyle(fontSize: 20, fontWeight: FontWeight.bold, color: Colors.white),),
        centerTitle: true,
        backgroundColor: Coloors.primaryColor,
      ),
      drawer: Drawer(
        child: ListView(
          padding: EdgeInsets.zero,
          children: <Widget>[
            const DrawerHeader(
              decoration: BoxDecoration(
                color: Coloors.primaryColor,
              ),
              child: Text(
                'UNI-CHECK',
                style: TextStyle(
                  color: Colors.white,
                  fontSize: 24,
                ),
              ),
            ),
            ListTile(
              leading: const FaIcon(FontAwesomeIcons.users),
              title: const Text('Utilisateurs'),
              onTap: () {
                Get.to(const UsersView());
              },
            ),
            ListTile(
              leading: const FaIcon(FontAwesomeIcons.list),
              title: const Text('Requêtes'),
              onTap: () {
                Get.to(const UsersView());
              },
            ),

          ],
        ),
      ),
      floatingActionButton: FloatingActionButton(
        backgroundColor: Coloors.primaryColor,
        onPressed: (){
          Get.to(const MatriculeIn());
        },
        child: const FaIcon(FontAwesomeIcons.plus, color: Colors.white),
      ),
      body: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          crossAxisAlignment: CrossAxisAlignment.center,
          children: [
            ElevatedButton(
              onPressed: () {
                Get.to(const InNfc());
              },
              style: ElevatedButton.styleFrom(
                  backgroundColor: const Color(0xFF1D5620),
                  shape: const CircleBorder(),
                  padding: const EdgeInsets.all(60),
                  elevation: 60,
                  shadowColor: Colors.black
              ),
              child: const Text(
                'SCAN',
                style: TextStyle(
                    fontSize: 28,
                    fontWeight: FontWeight.bold,
                  color: Colors.white
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }
}