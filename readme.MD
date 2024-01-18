---
Controle Financeiro: "Se você não comprar nada o desconto é maior"
---

# 1. Introdução

## Objetivo do Sistema:
O Sistema de Controle Financeiro tem como objetivo oferecer uma plataforma para gerenciamento eficiente de finanças pessoais, permitindo aos usuários um maior controle de suas receitas, despesas e dívidas de forma organizada.

## Escopo do Projeto:
O escopo do projeto inclui funcionalidades para inserção de receitas, registro de despesas, controle de dívidas com parcelamento, e consulta do saldo da conta.

# 2. Diagrama de Casos de Uso:
Diagrama de Casos de Uso UML:
[imagem]

# 3. Diagrama de Classes:
Diagrama de Classes UML:
[imagem]

# 4. Descrição Detalhada das Classes:

## **Classe Account:**

A classe Account representa a conta bancária do usuário.

*Atributos:*
- accountId: Identificador único da conta.
- balance: Saldo da conta.
- debts: Lista de dívidas associadas.

*Métodos:*
- getBalance(): Retorna o saldo atual da conta.
- addDebt(debt): Adiciona uma nova dívida à lista.

## **Classe Debt**

A classe Debt representa uma dívida com parcelamento.

*Atributos*
- debtId: Identificador único da dívida.
- totalAmount: Valor total da dívida.
- remainingAmount: Valor restante a ser pago.
- dueDate: Data de vencimento da dívida.
- installments: Lista de parcelas associadas à dívida.

*Métodos*
- getRemainingAmount(): Retorna o valor restante a ser pago.
- addInstallment(installment): Adiciona uma nova parcela à lista.

## **Classe Installment**

A classe Installment representa uma parcela de uma dívida.

*Atributos*
- installmentId: Identificador único da parcela.
- amount: Valor da parcela.
- dueDate: Data de vencimento da parcela.

## Diagrama de sequência:
1. Usuário seleciona a opção de inserir nova dívida.
2. Sistema solicita detalhes da dívida(totalAmount, dueDate).
3. Usuário fornece informações.
4. Sistema cria uma nova instância da classe **Debt**
5. Sistema solicita detalhes da primeira parcela.
6. Usuário fornece informações.
7. Sistema cria uma nova instância da classe **Installment** e a 
associa à dívida.
8. Passos 5-7 se repetem para as demais parcelas.
9. Sistema adiciona a dívida à lista de dívidas da conta.

# 6. Bando de Dados:

Estrutura do Banco de Dados:

## Account Table:
- accountId **(PK)**
- balance

## Debt Table:
- debtId **(PK)**
- accountId **(FK referenciando Account)**
- totalAmount

## Installment Table:
- installmentId **(PK)**
- debtId **(FK referenciando Account)**
- amount
- dueDate

*obs:* Ver o arquivo *database.db*

# 7. Considerações sobre as Boas Práticas:

## Princípios SOLID:
A ideia de dividir funcionalidades em classes específicas é 
aplicar o **princípio da responsabilidade única**.

A coesão e o baixo acoplamento foram considerados na definição das classes.

## Boas Práticas de Codificação:
Foram utilizadas convenções de nomeclatura claras e significativas para 
facilitar a compreensão do código.

# 8. Considerações de Segurança:
As informações sensíveis, como detalhes da conta, são protegidas por 
práticas de segurança, como autenticação e autorização.

# 9. Glossário
- Account: Representa a conta bancária do usuário.
- Debt: Representa uma dívida com parcelamento.
- Installment: Representa uma parcela de uma dívida.

# 10. Referências:
- <a href="https://www.omg.org/spec/UML/2.5.1/About-UML">UML Specification</a>
- <a href="https://www.w3schools.com/sql/sql_syntax.asp">SQL Syntax</a>
- <a href="https://dev.mysql.com/doc/refman/8.2/en/">MySQL Reference Manual</a>