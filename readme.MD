# Implementação de Serviço de Transferência de Dinheiro
Este repositório contém a solução desenvolvida para o desafio de criar uma mini banco simplificado. O desafio consiste na implementação de um serviço de transferência de dinheiro entre dois tipos de usuários: comuns e lojistas.

## Solução Desenvolvida
A implementação do serviço atende aos requisitos estabelecidos, e aqui estão os principais pontos desenvolvidos:

### Tecnologias Utilizadas
- `Lumen Framework:` Optei pelo Lumen como framework PHP para o desenvolvimento do serviço. Sua simplicidade e eficiência são ideais para a construção de APIs leves e rápidas.

- `MySQL:` O banco de dados escolhido foi o MySQL para armazenar as informações dos usuários, transações e outras entidades necessárias para o funcionamento do serviço.

### Estrutura do Projeto
A estrutura do projeto foi organizada de maneira clara e modular, respeitando boas práticas de arquitetura de software. Destaco a divisão entre modelos, controladores e serviços para facilitar a manutenção e escalabilidade da aplicação.

### Validação de Dados
CPF/CNPJ e E-mails Únicos: Implementei a validação para garantir que CPF/CNPJ e e-mails sejam únicos no sistema. Isso é fundamental para evitar duplicidades e garantir a integridade dos dados.

### Validação de Saldo
Antes de efetuar qualquer transferência, é realizada uma validação para garantir que o usuário tenha saldo suficiente para a operação.

### Integração com Serviços Externos
- `Mock de Autorização:` Utilizei o serviço de mock (https://run.mocky.io/v3/5794d450-d2e2-4412-8131-73d0293ac1cc) para simular a autorização externa antes de finalizar uma transferência. Isso garante uma camada adicional de segurança e validação.

### Mock de Notificação
Implementei a integração com o serviço de mock (https://run.mocky.io/v3/54dc2cf1-3add-45b5-b5a9-6bf7e7f1f4a6) para enviar notificações de pagamento a usuários e lojistas, mesmo considerando a eventual indisponibilidade/instabilidade do serviço de terceiros.

### Testes
Testes Unitários e de Integração: Para garantir a robustez da aplicação, foram desenvolvidos testes unitários e de integração. O uso de testes contribui para a manutenibilidade e qualidade do código.

### Documentação
`Readme.md Detalhado:`
Este documento serve como guia completo para a compreensão da solução desenvolvida. Ele inclui informações sobre a escolha de tecnologias, estrutura do projeto, validações implementadas e integração com serviços externos.

## Melhorias e Propostas
Durante o desenvolvimento, identifiquei algumas áreas que poderiam ser aprimoradas para melhorar a arquitetura e eficiência do serviço:

### Implementação de Filas
Para otimizar o processo de notificação, uma possível melhoria seria a implementação de filas de mensagens para lidar com envios assíncronos de notificações.

### Refatoração da Lógica de Transação
Embora a lógica de transação tenha sido implementada de acordo com os requisitos, uma revisão detalhada poderia identificar oportunidades de otimização e simplificação.

## Como Executar o Projeto Localmente
- Clone este repositório.
- Configure o ambiente PHP e o banco de dados MySQL conforme as especificações do arquivo .env.
- Execute as migrações para criar a estrutura do banco de dados: php artisan migrate.
- Inicie o servidor local: php -S localhost:8000 -t public.
- Acesse a API em http://localhost:8000.
- `Observação:` Certifique-se de ter o Composer instalado para gerenciar as dependências do projeto.

Considerações Finais
Esse foi um projeto de estudo que surgiu da necessidade de saber como bancos que usam o picpay poderiam
ter um backend feito em php. Com isso foi bem proveitoso aprender sobre Uuid e como garantir transações
com tratamentos de erros. Sinta-se a vontade para dar opiniões sobre o projeto.

# ToDo

## Auth
- [x] Autenticação com Laravel/Passport
- [x] Cobertura de código em 90% (Controller/Repository)
- [] Diagrama das classes

## Transaction
- [x] Lojistas (retailer) não podem fazer uma transferência
- [x] Criar transferência entre contas
- [] Cobertura de código de 90%
- [] Terminar testes com Retailer
- [] Diagrama das classes
