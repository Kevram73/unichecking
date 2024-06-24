class UserFields {
  static const String tableName = 'users';
  static const String id = 'id';
  static const String nfcKey = 'nfc_key';
  static const String matricule = 'matricule';
  static const String palmKey = 'palm_key';
  static late final DateTime createdTime;

  static final List<String> values = [
    id, nfcKey, matricule, palmKey, createdTime.toString()
  ];

  static const String idType = 'INTEGER PRIMARY KEY AUTOINCREMENT';
  static const String textType = 'TEXT NOT NULL';
  static const String intType = 'INTEGER NOT NULL';
}

class UserModel {
  final int? id;
  final String nfcKey;
  final String matricule;
  final String palmKey;
  final DateTime? createdTime;

  UserModel({this.id, required this.nfcKey, required this.matricule, required this.palmKey, this.createdTime});

  UserModel copy({int? id, String? nfcKey, String? matricule, String? palmKey, DateTime? createdTime}) =>
      UserModel(
          id: id ?? this.id,
          nfcKey: nfcKey ?? this.nfcKey,
          palmKey: palmKey ?? this.palmKey,
          matricule: matricule ?? this.matricule,
          createdTime: createdTime ?? this.createdTime);

  Map<String, Object?> toJson() => {
    UserFields.id: id,
    UserFields.nfcKey: nfcKey,
    UserFields.matricule: matricule,
    UserFields.palmKey: palmKey,
    UserFields.createdTime.toString(): createdTime.toString(),
  };

  static UserModel fromJson(Map<String, Object?> json) => UserModel(
    id: json[UserFields.id] as int?,
    matricule: json[UserFields.matricule] as String,
    nfcKey: json[UserFields.nfcKey] as String,
    palmKey: json[UserFields.palmKey] as String,
    createdTime: json[UserFields.createdTime] as DateTime,
  );
}
