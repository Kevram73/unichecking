import 'package:flutter/material.dart';

import '../../helpers/databaseHelper.dart';
import '../../models/user.dart';

class UsersView extends StatefulWidget {
  const UsersView({super.key});

  @override
  State<UsersView> createState() => _UsersViewState();
}

class _UsersViewState extends State<UsersView> {
  final UserDatabase userDatabase = UserDatabase.instance;
  List<UserModel> users = [];

  @override
  void initState() {
    super.initState();
    refreshUsers();
  }

  @override
  void dispose() {
    userDatabase.close();
    super.dispose();
  }

  Future<void> refreshUsers() async {
    final allUsers = await userDatabase.readAll();
    setState(() {
      users = allUsers;
    });
  }

  Future<void> goToUserDetailsView({int? id}) async {

    refreshUsers();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.grey[900],
      appBar: AppBar(
        title: const Text('User Management'),
        backgroundColor: Colors.grey[850],
        actions: [
          IconButton(
            onPressed: () {},
            icon: const Icon(Icons.search),
          ),
        ],
      ),
      body: Center(
        child: users.isEmpty
            ? const Text(
          'No users yet',
          style: TextStyle(color: Colors.white),
        )
            : ListView.builder(
            itemCount: users.length,
            itemBuilder: (context, index) {
              final user = users[index];
              return GestureDetector(
                onTap: () => goToUserDetailsView(id: user.id),
                child: Padding(
                  padding: const EdgeInsets.only(bottom: 10),
                  child: Card(
                    child: Padding(
                      padding: const EdgeInsets.all(8.0),
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: <Widget>[
                          Text(
                            user.createdTime as String, // Assumes createdTime is a String
                            style: TextStyle(color: Colors.grey[600]),
                          ),
                          Text(
                            '${user.matricule}, ${user.nfcKey}, ${user.palmKey}',

                          ),
                        ],
                      ),
                    ),
                  ),
                ),
              );
            }),
      ),
      floatingActionButton: FloatingActionButton(
        onPressed: () => goToUserDetailsView(),
        tooltip: 'Add User',
        child: const Icon(Icons.add),
      ),
    );
  }
}
