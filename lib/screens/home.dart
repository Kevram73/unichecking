import 'package:flutter/material.dart';
import 'package:font_awesome_flutter/font_awesome_flutter.dart';
import 'package:get/get.dart';
import 'package:zktecopalm/screens/admin/users.dart';
import 'package:zktecopalm/screens/in_nfc.dart';
import 'package:zktecopalm/screens/matricule_in.dart';
import 'package:zktecopalm/screens/register_palm.dart';
import 'package:zktecopalm/screens/sign_nfc.dart';

import '../helpers/coloors.dart';

class Home extends StatelessWidget {
  const Home({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Uni-Check', style: TextStyle(fontSize: 20, fontWeight: FontWeight.bold),),
        centerTitle: true,
        backgroundColor: Coloors.primaryColor,
      ),
      drawer: Drawer(
        child: ListView(
          padding: EdgeInsets.zero,
          children: <Widget>[
            DrawerHeader(
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
              leading: FaIcon(FontAwesomeIcons.users),
              title: Text('Utilisateurs'),
              onTap: () {
                Get.to(UsersView());
              },
            ),
            ListTile(
              leading: FaIcon(FontAwesomeIcons.list),
              title: Text('Requêtes'),
              onTap: () {
                Get.to(UsersView());
              },
            ),

          ],
        ),
      ),
      floatingActionButton: FloatingActionButton(
        backgroundColor: Coloors.primaryColor,
        onPressed: (){
          Get.to(MatriculeIn());
        },
        child: FaIcon(FontAwesomeIcons.plus),
      ),
      body: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          crossAxisAlignment: CrossAxisAlignment.center,
          children: [
            ElevatedButton(
              onPressed: () {
                Get.to(InNfc());
              },
              style: ElevatedButton.styleFrom(
                  backgroundColor: Color(0xFF1D5620),
                  shape: CircleBorder(),
                  padding: EdgeInsets.all(60),
                  elevation: 60,
                  shadowColor: Colors.black
              ),
              child: const Text(
                'SCAN',
                style: TextStyle(
                    fontSize: 28,
                    fontWeight: FontWeight.bold
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }
}