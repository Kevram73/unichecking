import 'package:flutter/material.dart';
import 'package:font_awesome_flutter/font_awesome_flutter.dart';
import 'package:get/get.dart';
import 'package:zktecopalm/screens/admin/users.dart';
import 'package:zktecopalm/screens/in_nfc.dart';
import 'package:zktecopalm/screens/matricule_in.dart';

import '../controllers/MainController.dart';
import '../helpers/coloors.dart';

class Home extends StatelessWidget {
  Home({Key? key}) : super(key: key);

  final MainController _controller = Get.put(MainController());

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
      body: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        crossAxisAlignment: CrossAxisAlignment.center,
        children: [

          const Row(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Text("Timelapse: 00:00:00", style: TextStyle(fontSize: 30),),
            ],
          ),
          const SizedBox(height: 40),
          Text("Votre carte NFC", style: TextStyle(fontSize: 24),),
          const SizedBox(height: 40),
          Center(
            child: Row(
              mainAxisAlignment: MainAxisAlignment.center,
              crossAxisAlignment: CrossAxisAlignment.center,
              children: [
                ElevatedButton(
                  onPressed: _controller.isPressed?null: () {_controller.isPressed = false;},
                  style: ElevatedButton.styleFrom(
                      backgroundColor: const Color(0xFF1D5620),
                      shape: const CircleBorder(),
                      padding: const EdgeInsets.all(50),
                      elevation: 50,
                      shadowColor: Colors.black
                  ),
                  child: const Text(
                    'BEGIN',
                    style: TextStyle(
                        fontSize: 20,
                        fontWeight: FontWeight.w300,
                      color: Colors.white
                    ),
                  ),

                ),
                ElevatedButton(
                  onPressed: _controller.isPressed?() {_controller.isPressed = false;} : null,
                  style: ElevatedButton.styleFrom(
                      backgroundColor: _controller.isPressed? const Color(0xFF1D5620): Colors.grey,
                      shape: const CircleBorder(),
                      padding: const EdgeInsets.all(50),
                      elevation: 50,
                      shadowColor: Colors.black
                  ),
                  child: const Text(
                    'END',
                    style: TextStyle(
                        fontSize: 20,
                        fontWeight: FontWeight.w300,
                        color: Colors.white
                    ),
                  ),

                ),
              ],
            ),
          ),
        ],
      ),
    );
  }
}