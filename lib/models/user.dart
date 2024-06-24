class UserFields {
  static final String tableName = 'users';
  static final String id = '_id';
  static final String name = 'name';
  static final String age = 'age';
  static final String createdTime = 'createdTime';

  static final List<String> values = [
    id, name, age, createdTime
  ];

  static final String idType = 'INTEGER PRIMARY KEY AUTOINCREMENT';
  static final String textType = 'TEXT NOT NULL';
  static final String intType = 'INTEGER NOT NULL';
}

class UserModel {
  final int? id;
  final String name;
  final int age;
  final String createdTime;

  UserModel({this.id, required this.name, required this.age, required this.createdTime});

  UserModel copy({int? id, String? name, int? age, String? createdTime}) =>
      UserModel(
          id: id ?? this.id,
          name: name ?? this.name,
          age: age ?? this.age,
          createdTime: createdTime ?? this.createdTime);

  Map<String, Object?> toJson() => {
    UserFields.id: id,
    UserFields.name: name,
    UserFields.age: age,
    UserFields.createdTime: createdTime,
  };

  static UserModel fromJson(Map<String, Object?> json) => UserModel(
    id: json[UserFields.id] as int?,
    name: json[UserFields.name] as String,
    age: json[UserFields.age] as int,
    createdTime: json[UserFields.createdTime] as String,
  );
}
