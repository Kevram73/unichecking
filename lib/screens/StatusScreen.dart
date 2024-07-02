import 'package:flutter/material.dart';

class StatusScreen extends StatelessWidget {
  const StatusScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text("Hello"),),
      body: const Center(
        child: Text("Success", style: TextStyle(fontSize: 25),),
      ),
    );
  }
}
