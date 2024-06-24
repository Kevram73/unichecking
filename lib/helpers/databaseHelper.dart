import 'package:path/path.dart';
import 'package:sqflite/sqflite.dart';

import '../models/user.dart';

class UserDatabase {
  static final UserDatabase instance = UserDatabase._init();

  static Database? _database;

  UserDatabase._init();

  Future<Database> get database async {
    if (_database != null) return _database!;
    _database = await _initDatabase('users.db');
    return _database!;
  }

  Future<Database> _initDatabase(String filePath) async {
    final dbPath = await getDatabasesPath();
    final path = join(dbPath, filePath);

    return await openDatabase(path, version: 1, onCreate: _createDB);
  }

  Future _createDB(Database db, int version) async {
    const idType = 'INTEGER PRIMARY KEY AUTOINCREMENT';
    const textType = 'TEXT NOT NULL';
    const intType = 'INTEGER NOT NULL';

    await db.execute('''
CREATE TABLE ${UserFields.tableName} (
  ${UserFields.id} $idType,
  ${UserFields.name} $textType,
  ${UserFields.age} $intType,
  ${UserFields.createdTime} $textType
)
''');
  }

  Future<UserModel> create(UserModel user) async {
    final db = await instance.database;
    final id = await db.insert(UserFields.tableName, user.toJson());
    return user.copy(id: id);
  }

  Future<UserModel> read(int id) async {
    final db = await instance.database;
    final maps = await db.query(
      UserFields.tableName,
      columns: UserFields.values,
      where: '${UserFields.id} = ?',
      whereArgs: [id],
    );

    if (maps.isNotEmpty) {
      return UserModel.fromJson(maps.first);
    } else {
      throw Exception('ID $id not found');
    }
  }

  Future<List<UserModel>> readAll() async {
    final db = await instance.database;
    final orderBy = '${UserFields.createdTime} DESC';
    final result = await db.query(UserFields.tableName, orderBy: orderBy);
    return result.map((json) => UserModel.fromJson(json)).toList();
  }

  Future<int> update(UserModel user) async {
    final db = await instance.database;
    return db.update(
      UserFields.tableName,
      user.toJson(),
      where: '${UserFields.id} = ?',
      whereArgs: [user.id],
    );
  }

  Future<int> delete(int id) async {
    final db = await instance.database;
    return db.delete(
      UserFields.tableName,
      where: '${UserFields.id} = ?',
      whereArgs: [id],
    );
  }

  Future close() async {
    final db = await instance.database;
    db.close();
  }
}
