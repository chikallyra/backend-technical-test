import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

void main() => runApp(
  const MaterialApp(home: LoginPage(), debugShowCheckedModeBanner: false),
);

const String baseUrl = "http://10.xxx.xxx.xxx:8080/api";

class LoginPage extends StatefulWidget {
  const LoginPage({super.key});
  @override
  State<LoginPage> createState() => _LoginPageState();
}

class _LoginPageState extends State<LoginPage> {
  final TextEditingController emailController = TextEditingController();
  final TextEditingController passwordController = TextEditingController();

  Future<void> login() async {
    try {
      var response = await http.post(
        Uri.parse('$baseUrl/login'),
        body: {
          'email': emailController.text,
          'password': passwordController.text,
        },
      );

      var data = json.decode(response.body);
      if (response.statusCode == 200) {
        _showMsg("Login Berhasil! Halo ${data['data']['name']}");
      } else {
        _showMsg(data['message'] ?? "Email/Password salah");
      }
    } catch (e) {
      _showMsg("Kesalahan koneksi: $e");
    }
  }

  void _showMsg(String msg) {
    ScaffoldMessenger.of(context).showSnackBar(SnackBar(content: Text(msg)));
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text("Coralis - Login")),
      body: Padding(
        padding: const EdgeInsets.all(20),
        child: Column(
          children: [
            TextField(
              controller: emailController,
              decoration: const InputDecoration(labelText: "Email"),
            ),
            TextField(
              controller: passwordController,
              decoration: const InputDecoration(labelText: "Password"),
              obscureText: true,
            ),
            const SizedBox(height: 20),
            ElevatedButton(onPressed: login, child: const Text("LOGIN")),
            TextButton(
              onPressed: () => Navigator.push(
                context,
                MaterialPageRoute(builder: (c) => const RegisterPage()),
              ),
              child: const Text("Belum punya akun? Daftar disini"),
            ),
            TextButton(
              onPressed: () => Navigator.push(
                context,
                MaterialPageRoute(builder: (c) => const ForgotPasswordPage()),
              ),
              child: const Text("Lupa Password?"),
            ),
          ],
        ),
      ),
    );
  }
}

// --- HALAMAN REGISTER ---
class RegisterPage extends StatefulWidget {
  const RegisterPage({super.key});
  @override
  State<RegisterPage> createState() => _RegisterPageState();
}

class _RegisterPageState extends State<RegisterPage> {
  final nameController = TextEditingController();
  final emailController = TextEditingController();
  final passwordController = TextEditingController();

  Future<void> register() async {
    try {
      var response = await http.post(
        Uri.parse('$baseUrl/register'),
        body: {
          'name': nameController.text,
          'email': emailController.text,
          'password': passwordController.text,
        },
      );

      var data = json.decode(response.body);
      if (response.statusCode == 201) {
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(content: Text("Registrasi Berhasil! Silahkan Login")),
        );
        Navigator.pop(context);
      } else {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(
            content: Text("Gagal: ${data['messages'] ?? data['message']}"),
          ),
        );
      }
    } catch (e) {
      print(e);
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text("Daftar Akun Baru")),
      body: Padding(
        padding: const EdgeInsets.all(20),
        child: Column(
          children: [
            TextField(
              controller: nameController,
              decoration: const InputDecoration(labelText: "Nama Lengkap"),
            ),
            TextField(
              controller: emailController,
              decoration: const InputDecoration(labelText: "Email"),
            ),
            TextField(
              controller: passwordController,
              decoration: const InputDecoration(
                labelText: "Password (Min. 6 Karakter)",
              ),
              obscureText: true,
            ),
            const SizedBox(height: 20),
            ElevatedButton(onPressed: register, child: const Text("DAFTAR")),
          ],
        ),
      ),
    );
  }
}

// --- HALAMAN LUPA PASSWORD ---
class ForgotPasswordPage extends StatefulWidget {
  const ForgotPasswordPage({super.key});
  @override
  State<ForgotPasswordPage> createState() => _ForgotPasswordPageState();
}

class _ForgotPasswordPageState extends State<ForgotPasswordPage> {
  final emailController = TextEditingController();
  final tokenController = TextEditingController();
  final passwordController = TextEditingController();
  bool isTokenReceived = false;

  Future<void> sendToken() async {
    var res = await http.post(
      Uri.parse('$baseUrl/forgot-password'),
      body: {'email': emailController.text},
    );
    var data = json.decode(res.body);
    if (res.statusCode == 200) {
      setState(() => isTokenReceived = true);
      showDialog(
        context: context,
        builder: (c) => AlertDialog(
          title: const Text("Token Kamu"),
          content: Text(data['token']),
        ),
      );
    }
  }

  Future<void> resetPassword() async {
    var res = await http.post(
      Uri.parse('$baseUrl/reset-password'),
      body: {
        'token': tokenController.text,
        'password': passwordController.text,
      },
    );
    if (res.statusCode == 200) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text("Password Berhasil Diganti!")),
      );
      Navigator.pop(context);
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text("Reset Password")),
      body: Padding(
        padding: const EdgeInsets.all(20),
        child: !isTokenReceived
            ? Column(
                children: [
                  TextField(
                    controller: emailController,
                    decoration: const InputDecoration(
                      labelText: "Masukkan Email Terdaftar",
                    ),
                  ),
                  ElevatedButton(
                    onPressed: sendToken,
                    child: const Text("KIRIM TOKEN"),
                  ),
                ],
              )
            : Column(
                children: [
                  TextField(
                    controller: tokenController,
                    decoration: const InputDecoration(
                      labelText: "Masukkan Token",
                    ),
                  ),
                  TextField(
                    controller: passwordController,
                    decoration: const InputDecoration(
                      labelText: "Password Baru",
                    ),
                    obscureText: true,
                  ),
                  ElevatedButton(
                    onPressed: resetPassword,
                    child: const Text("UPDATE PASSWORD"),
                  ),
                ],
              ),
      ),
    );
  }
}
