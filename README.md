# INSTITUTO FEDERAL DO MARANHÃO
# RAFAEL CORREIA PAZ
# iFleet - Sistema de Controle de Frotas

Se quiseres, pode fazer um teste neste servidor:
https://viaradio.jupiter.com.br/iFleet/

## Singleton
api/utils/DB.class.php

Cria uma instância única para conexão com banco de dados.

## Strategy
api/model/documento/AcadastroPessoa.class.php
api/model/documento/CNPJ.class.php
api/model/documento/CPF.class.php

Polimorfismo para documentos CPF e CNPJ

## Factory Method
api/service/DocumentoCadastroFactory.class.php

Retorna a instância da classe do documento utilizado pelo fornecedor.

## Template Method
api/utils/APDF.class.php
api/utils/RelatorioControlePDF.class.php
api/utils/ControlePDF.class.php

Cria um Template Method com a função montarPDF na classe APDF, para ser utilizada na criação de arquivos PDF's, mudando somente o conteúdo.

## Adapter
api/utils/MailAdapter.class.php

Faz adaptação da classe Mail para se utilizada no Facade.

## Facade
api/service/ComunicacaoFacade.class.php

Cria uma fachada para Comunicação, usando o MailAdapter.class.php e SMS.class.php