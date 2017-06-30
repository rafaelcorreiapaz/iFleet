# INSTITUTO FEDERAL DO MARANH�O
# RAFAEL CORREIA PAZ
# iFleet - Sistema de Controle de Frotas

Se quiseres, pode fazer um teste neste servidor:
https://viaradio.jupiter.com.br/iFleet/

## Singleton
api/utils/DB.class.php

Cria uma inst�ncia �nica para conex�o com banco de dados.

## Strategy
api/model/documento/AcadastroPessoa.class.php
api/model/documento/CNPJ.class.php
api/model/documento/CPF.class.php

Polimorfismo para documentos CPF e CNPJ

## Factory Method
api/service/DocumentoCadastroFactory.class.php

Retorna a inst�ncia da classe do documento utilizado pelo fornecedor.

## Template Method
api/utils/APDF.class.php
api/utils/RelatorioControlePDF.class.php
api/utils/ControlePDF.class.php

Cria um Template Method com a fun��o montarPDF na classe APDF, para ser utilizada na cria��o de arquivos PDF's, mudando somente o conte�do.

## Adapter
api/utils/MailAdapter.class.php

Faz adapta��o da classe Mail para se utilizada no Facade.

## Facade
api/service/ComunicacaoFacade.class.php

Cria uma fachada para Comunica��o, usando o MailAdapter.class.php e SMS.class.php