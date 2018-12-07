#include "/usr/include/jsoncpp/json/json.h"
#include "/usr/include/mysql/mysql.h"
#include <cstring>
#include <fstream>
#include <iostream>
#include <queue>
#include <string>
#include <vector>

using namespace std;

#define HOST "localhost"
#define USER "root"
#define PASS "132567"
#define DB "exercicio"

vector<string> explode(string separador, string frase)
{
  int prox = separador.size();
  vector<string> retorno;
  string word = "";
  string::size_type ini, fim;
  ini = fim = 0;
  while (true)
  {
    fim = frase.find(separador, ini);
    if (fim == string::npos)
    {
      word = frase.substr(ini, frase.size() - ini);
      if (word.size() > 0)
      {
        retorno.push_back(word);
      }
      break;
    }
    word = frase.substr(ini, fim - ini);
    if (word.size() > 0)
    {
      retorno.push_back(word);
    }
    ini = fim + prox;
  }
  return retorno;
}

int main(int argc, char const *argv[]){
  MYSQL *conn;
  conn = mysql_init(NULL);
  if (mysql_real_connect(conn, HOST, USER, PASS, DB, 0, NULL, 0) == NULL)  {
    cout << "Error ao Iniciar o DB";
    mysql_close(conn);
    return 0;
  }
  
  string op = string(argv[1]);

  if (op == "listarUsuario")  {
    if (argc != 2)    {
      cout << " Parametros Invalidos !" << endl;
      return 0;
    }
    string query = "SELECT usuarios.usuario, usuarios.login , usuarios.senha FROM exercicio.usuarios";
    mysql_query(conn,query.c_str());

    MYSQL_RES *resultado;
    MYSQL_ROW linhas;

    Json::Value valor, JSON;

    resultado = mysql_store_result(conn);
    while ((linhas = mysql_fetch_row(resultado))){
      valor["usuario"] = linhas[0];
      valor["login"] = linhas[1];
      valor["senha"] = linhas[2];
      JSON.append(valor);
      valor.clear();
    }

    Json::FastWriter leia;

    cout << leia.write(JSON);

    mysql_free_result(resultado);
    mysql_close(conn);
  }

  else if (op == "cadastro"){
    if (argc != 5){
      cout << " Parametros Invalidos !" << endl;
      return 0;
    }

    if (string(argv[2]) == "" || string(argv[3]) == "" || string(argv[4]) == ""){
      cout << "3";
      mysql_close(conn);
    }

    string nome = string(argv[2]);
    string login = string(argv[3]);
    string senha = string(argv[4]);

    MYSQL_RES *resultado;

    string query = "SELECT usuarios.login FROM usuarios WHERE usuarios.login = '" + login + "'";
    mysql_query(conn,query.c_str());

    resultado = mysql_store_result(conn);
    int linhas = mysql_num_rows(resultado);

    if (linhas == 0){
      string query = "INSERT INTO usuarios(usuario,login,senha)VALUES('" + nome + "','" + login + "','" + senha + "')";
      mysql_query(conn,query.c_str());
      cout << "1";
    }
    else{
      cout << "2";
    }

    mysql_free_result(resultado);
    mysql_close(conn);
  }

  else if (op == "login"){
    if (argc != 4){
      cout << " Parametros Invalidos !" << endl;
      return 0;
    }

    MYSQL_RES *resultado;
    string login = string(argv[2]);
    string senha = string(argv[3]);
    string query = "SELECT usuarios.login,usuarios.senha FROM usuarios WHERE usuarios.login ='" + login + "' AND usuarios.senha = '" + senha + "'";
    mysql_query(conn,query.c_str());

    resultado = mysql_store_result(conn);
    int linhas = mysql_num_rows(resultado);

    if (linhas == 1){
      cout << "1";
    }
    else{
      cout << "2";
    }

    mysql_free_result(resultado);
    mysql_close(conn);
  }

  else if (op == "editar"){
    if (argc != 6){
      cout << " Parametros Invalidos !" << endl;
      return 0;
    }

    MYSQL_RES *resultado;
    string atualLogin = string(argv[2]);
    string atualSenha = string(argv[3]);
    string Usuario = string(argv[4]);
    string Senha = string(argv[5]);
    string query = "SELECT usuario FROM usuarios WHERE senha = '" + atualSenha + "' AND login='" + atualLogin + "'";
    
    mysql_query(conn,query.c_str());
    resultado = mysql_store_result(conn);
    int linhas = mysql_num_rows(resultado);
    if (linhas > 0){
      string query = "UPDATE usuarios SET usuarios.usuario='" + Usuario + "', usuarios.senha='" + Senha + "' WHERE usuarios.login='" + atualLogin + "' AND usuarios.senha ='" + atualSenha + "'";
      mysql_query(conn,query.c_str());
      resultado = mysql_store_result(conn);
      int linhas = mysql_affected_rows(conn);
      if (linhas > 0){
        cout << "1";
      }
    }
    else{
      cout << "2";
    }

    mysql_free_result(resultado);
    mysql_close(conn);
  }

  else if (op == "listar"){
    if (argc != 2){
      cout << " Parametros Invalidos !" << endl;
      return 0;
    }

    string query = "SELECT contatos.ID,contatos.nome, contatos.sobrenome, contatos.endereco ,contatos.telefone,contatos.data_nascimento FROM exercicio.contatos";
    mysql_query(conn,query.c_str());

    MYSQL_RES *resultado;
    MYSQL_ROW linhas;

    Json::Value valor, JSON;

    resultado = mysql_store_result(conn);
    while ((linhas = mysql_fetch_row(resultado))){
      valor["ID"] = linhas[0];
      valor["nome"] = linhas[1];
      valor["sobrenome"] = linhas[2];
      valor["endereco"] = linhas[3];
      valor["telefone"] = linhas[4];
      valor["data_nascimento"] = linhas[5];

      JSON.append(valor);
      valor.clear();
    }

    Json::FastWriter leia;
    cout << leia.write(JSON);
    mysql_free_result(resultado);
    mysql_close(conn);

  }

  else if (op == "adicionar"){
    if (argc != 7){
      cout << " Parametros Invalidos !" << endl;
      return 0;
    }

    string nome = string(argv[2]);
    string sobrenome = string(argv[3]);
    string endereco = string(argv[4]);
    string telefone = string(argv[5]);
    string data_nascimento = string(argv[6]);

    if(nome == "" || sobrenome == "" || endereco == "" || telefone.size() < 15){
      cout << "5";
    }else{
      string query = "INSERT INTO contatos(nome,sobrenome,endereco,telefone,data_nascimento)VALUES('" + nome + "','" + sobrenome + "','" + endereco + "','" + telefone + "','" + data_nascimento + "')";
      mysql_query(conn,query.c_str());
      int linhas = mysql_affected_rows(conn);
      if (linhas > 0){
        cout << "1";
      }
      else{
        cout << "2";
      }
    }
    mysql_close(conn);
  }

  else if (op == "remover"){
    if (argc != 3){
      cout << " Parametros Invalidos !" << endl;
      return 0;
    }

    string ID = string(argv[2]);
    string query = "DELETE FROM contatos WHERE ID = '" + ID + "'";
    mysql_query(conn,query.c_str());
    int linhas = mysql_affected_rows(conn);
    if (linhas > 0){
      cout << "1";
    }
    else{
      cout << "2";
    }

    mysql_close(conn);
  }

  
  else if (op == "listarRota"){
    if (argc != 2){
      cout << " Parametros Invalidos !" << endl;
      return 0;
    }
    int count = 0;
    Json::Value valor, JSON;
    Json::FastWriter leia;
    FILE *proc = popen("route -n", "r");
    char retorno[500];
    vector<string> texto;
    while (proc && fgets(retorno, 500, proc)){
      texto = explode(" ", retorno);
      if (texto.size() != 8){
        continue;
      }
      if (count >= 1){
        valor["Destino"] = texto[0];
        valor["Roteador"] = texto[1];
        valor["MascaraGen"] = texto[2];
        valor["Opcoes"] = texto[3];
        valor["Metrica"] = texto[4];
        valor["Ref"] = texto[5];
        valor["Uso"] = texto[6];
        valor["Iface"] = texto[7].substr(0, texto[7].size() - 1);
        JSON.append(valor);
        valor.clear();
      }
      count++;
    }
    cout << leia.write(JSON);
    pclose(proc);
  }         

  
  else if (op == "delRota"){
    if (argc != 5){
      cout << " Parametros Invalidos !" << endl;
      return 0;
    }
    string network = string(argv[2]);
    string netmask = string(argv[3]);   
    string gateway = string(argv[4]);
    string comand = "sudo route del -net "+network+" netmask "+netmask+"  gw "+gateway+" ";
    if(system(comand.c_str())){
      cout << "2";
    }
    else{
      cout << "3";
    }
  }             

  else if (op == "addRota"){
    if (argc != 6){
      cout << " Parametros Invalidos !" << endl;
      return 0;
    }
    string network = string(argv[2]);
    string gateway = string(argv[3]); 
    string metrica = string(argv[4]);
    string iface = string(argv[5]);   
    
    string comand = "sudo route add -net "+network+" gw "+gateway+" metric "+metrica+" dev "+iface+"";
    if(system(comand.c_str()) == 0){
      cout << "1";
    }
  }           

  return 0;
}
