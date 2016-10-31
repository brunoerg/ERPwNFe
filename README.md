# ERP com EmissorNFe
Projeto open source de um sistema erp completo com emissão de nota fiscal eletronica com a API NFePHP.

##História do sistema
Não desenvolvi ele por inteiro, recebi esse sistema, principalmente o front-end de um amigo que me disse ter esse projeto abandonado, logo, ele me deu o script e a partir de então, tentei ao máximo deixar o back-end melhor, atualizei a API da NFe, corrigi bugs, etc. Por se tratar de um sistema complexo ainda tem bugs e vamos cada dia mais juntos corrigindo o sistema.

**O intuito do projeto é vocês utilizarem esse sistema para usarem pra si mesmos, principalmente porque o governo vai retirar o sistema público do ar, queremos sempre cuidar desse sistema para vocês poderem usar com qualidade, portanto, quem quiser fazer doação vamos ficar contente.** https://pag.ae/bgdz8fM

##SISTEMA DESENVOLVIDO COM
PHP OO
MVC
BOOTSTRAP
NFePHP
MySQL

## Instruções de Instalação
1. Criar banco de dados MySQL, importando modelo do arquivo **nfe.sql**.
2. Ajustar dados do banco de dados em **APP/CONFIG/DATABASE.PHP**.
3. Alterar URL local em **APP/CONFIG/PATHS.PHP** conforme modelo abaixo:
```
//url = apenas oNomeQueVoceColocou
define('URL','http://'.$_SERVER['SERVER_NAME'].'/app/');
//folder = oNomeQueVoceColocou/app
define('Folder','http://'.$_SERVER['SERVER_NAME'].'/app/public/');
```

4. Alterar o nome da pasta ERP pelo nome de sua pasta onde instalou o sistema na www no arquivo **htaccess**. Alterar especificamente:
```

RewriteBase /oNomeQueVoceColocou/app/ 

```
5. Configurar NFE no arquivo **app/public/complementos/nfephp/config/config.php**

Nota: Verificar 3.10 Editar todas as variaveis e caminhos corretamentes, inclusive Certificado.
