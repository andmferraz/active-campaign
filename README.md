# Deep Data Integrations - ActiveCampaign
Exemplo de uma aplicação utilizando a API do ActiveCampaign para abandono de carrinho em um e-commerce.
Com os comandos apresentados é possível enviar um carrinho abandonado para uma automação previamente criada no painel de administração do AC.
Para mais detalhes acesse a [documentação](https://developers.activecampaign.com/v3/reference) completa.

PS.: Foi utilizada a biblioteca [Guzzle](http://docs.guzzlephp.org/en/stable/) para fazer as requisições PHP. Para mais informações consulte a [documentação](http://docs.guzzlephp.org/en/stable/quickstart.html).

## URL
A API é acessada usando um URL base específico da sua conta. O URL da sua API pode ser encontrado em sua conta na página Minhas configurações, na guia "Desenvolvedor". Além disso, os caminhos da URL devem começar com /api/3 para especificar a versão 3 da API. Geralmente, o URL está no formato https://<sua conta>.api-us1.com/api/3/<resource>. Todas as chamadas de API devem ser feitas por HTTPS.

## Autenticação
Todas as solicitações para a API são autenticadas, fornecendo sua chave de API. A chave da API deve ser fornecida como um cabeçalho HTTP chamado Api-Token.

## HTTP Methods
A API v3 usa métodos HTTP padrão para indicar a ação a ser executada em um recurso.

GET -    Recupera um recurso.
POST -   Cria um novo recurso.
PUT -    Atualiza um recurso.
DELETE - Remove um recurso.

## Connections
Os recursos de conexão Deep Data representam um link entre uma conta do ActiveCampaign e uma conta em algum serviço externo, como o Shopify. Esta API deve ser usada por terceiros que criam integrações entre esses serviços e o ActiveCampaign. A API permite criar, excluir e atualizar conexões. Você pode recuperar conexões individuais, bem como uma lista de todas as conexões em uma conta.

PS: As conexões associadas às integrações desenvolvidas internamente pelo ActiveCampaign podem ser recuperadas, mas não modificadas pela API.
### Criar uma conexão:
 ##### - POST https://youraccountname.api-us1.com/api/3/connections
Cria uma nova conexão
Parâmetros obrigatórios: connection.service (string) | connection.externalid (string) | connection.name (string) | connection.logoUrl (string) | connection.linkUrl (string)
### JSON
```
{
  "connection": {
    "service": "serviceName",
    "externalid": "abc123def456",
    "name": "Service Test",
    "logoUrl": "http://dominio.com/path/imagename.png",
    "linkUrl": "http://dominio.com/foo/"
  }
}
```
### Recuperar uma conexão:
 ##### - GET https://youraccountname.api-us1.com/api/3/connections/id
Recupera uma conexão
Parâmetros obrigatórios: id (string)
### Editar uma conexão:
 ##### - PUT https://youraccountname.api-us1.com/api/3/connections/id
Editar uma conexão
Parâmetros obrigatórios: id (string)
### JSON
```
{
  "connection": {
    "externalid": "email@example.com",
    "name": "Name test"
  }
}
```
### Deletar uma conexão:
 ##### - DELETE https://youraccountname.api-us1.com/api/3/connections/id
Deleta uma conexão
Parâmetros obrigatórios: id (string)
### Listar todas as conexões:
 ##### - GET https://youraccountname.api-us1.com/api/3/connections
Lista todas as conexões

## Clientes do E-commerce
Os recursos do cliente de comércio eletrônico representam um cliente em um serviço de comércio eletrônico externo, como o Shopify. Os recursos do cliente mantêm principalmente dados agregados de comércio eletrônico associados a um contato, incluindo a receita total, o número total de pedidos e o número total de produtos pedidos. Esses dados não podem ser salvos diretamente em um objeto de cliente, mas serão atualizados quando os recursos do pedido forem criados ou atualizados para um cliente. Observe que um cliente está relacionado a um contato pelo endereço de email.

### Criar um cliente:
 ##### - POST https://youraccountname.api-us1.com/api/3/ecomCustomers
Cria um cliente
Parâmetros obrigatórios: ecomCustomer.connectionid (string) | ecomCustomer.externalid (string) | ecomCustomer.email (string)
### JSON
```
{
  "ecomCustomer": {
    "connectionid": "1",
    "externalid": "56789",
    "email": "email@example.com",
    "acceptsMarketing": "1"
  }
}
```
### Recuperar um cliente:
 ##### - GET https://youraccountname.api-us1.com/api/3/ecomCustomers/id
Recupera um cliente
Parâmetros obrigatórios: id (string)
### Editar um cliente:
 ##### - PUT https://youraccountname.api-us1.com/api/3/ecomCustomers/id
Editar um cliente
Parâmetros obrigatórios: id (string)
### JSON
```
{
  "ecomCustomer": {
    "externalid": "98765"
  }
}
```
### Deletar um cliente:
 ##### - DELETE https://youraccountname.api-us1.com/api/3/ecomCustomers/id
Deleta um cliente
Parâmetros obrigatórios: id (string)
### Listar todos os clientes:
 ##### - GET https://youraccountname.api-us1.com/api/3/ecomCustomers
Lista todos os clientes

## Ordens do E-commerce
Os recursos de pedidos de comércio eletrônico representam pedidos em um serviço de comércio eletrônico externo, como o Shopify. A API permite criar, atualizar e excluir recursos do pedido. Você pode recuperar pedidos individuais, bem como uma lista de todos os pedidos. Antes de criar qualquer pedido, você deve ter criado um recurso de conexão para o serviço de comércio eletrônico e um recurso do cliente para o cliente que fez o pedido.

Sempre que os recursos do pedido são salvos por meio da API, os campos de dados agregados do recurso do cliente relacionado são atualizados automaticamente.

### Criar uma ordem:
 ##### - POST https://youraccountname.api-us1.com/api/3/ecomOrders
Cria uma ordem
Parâmetros obrigatórios: ecomOrder.externalid (string) | ecomOrder.email (string) | ecomOrder.orderProducts.name (string) | ecomOrder.orderProducts.price (int32) | ecomOrder.orderProducts.quantity (int32) | ecomOrder.totalPrice (int32) | ecomOrder.currency (int32) | ecomOrder.connectionid (int32) | ecomOrder.customerid (int32) | ecomOrder.orderDate (date)
### JSON
```
{
  "ecomOrder": {
    "externalid": "3246315233",
    "source": "1",
    "email": "alice@example.com",
    "orderNumber": "1057",
    "orderProducts": [
      {
        "externalid": "PROD12345",
        "name": "Pogo Stick",
        "price": "4900",
        "quantity": "1",
        "category": "Toys"
      },
      {
        "externalid": "PROD23456",
        "name": "Skateboard",
        "price": "3000",
        "quantity": "1",
        "category": "Toys"
      }
    ],
    "orderUrl": "https://example.com/orders/3246315233",
    "orderDate": "2016-09-13T17:41:39-04:00",
    "shippingMethod": "UPS Ground",
    "totalPrice": "9111",
    "currency": "USD",
    "connectionid": "1",
    "customerid": "1"
  }
}
```
### Deletar uma ordem:
 ##### - DELETE https://youraccountname.api-us1.com/api/3/ecomOrders/ecomOrderId
Deleta um cliente
Parâmetros obrigatórios: ecomOrderId (int32)
### Listar todas as ordens:
 ##### - GET https://youraccountname.api-us1.com/api/3/ecomOrders
Lista todas as ordens
### Editar uma ordem:
 ##### - PUT https://youraccountname.api-us1.com/api/3/ecomOrders/ecomOrderId
Editar uma ordem
Parâmetros obrigatórios: ecomOrderId (string)
### JSON
```
{
  "ecomOrder": {
    "externalid": "3246315237",
    "email": "alice@example.com",
    "orderProducts": [
      {
        "externalid": "PROD12345",
        "name": "Pogo Stick",
        "price": 4900,
        "quantity": 1,
        "category": "Toys",
        "sku": "POGO-12",
        "description": "lorem ipsum...",
        "imageUrl": "https://example.com/product.jpg",
        "productUrl": "https://store.example.com/product12345"
      },
      {
        "externalid": "PROD23456",
        "name": "Skateboard",
        "price": 3000,
        "quantity": 1,
        "category": "Toys",
        "sku": "SK8BOARD145",
        "description": "lorem ipsum...",
        "imageUrl": "https://example.com/product.jpg",
        "productUrl": "https://store.example.com/product45678"
      }
    ],
    "externalUpdatedDate": "2016-09-15T17:41:39-04:00",
    "shippingMethod": "UPS Ground",
    "totalPrice": 9111,
    "shippingAmount": 200,
    "taxAmount": 500,
    "discountAmount": 100,
    "currency": "USD",
    "orderNumber":"12345-1"
  }
}
```
## Carrinhos abandonados do E-Commerce
Os recursos de carrinho abandonado de comércio eletrônico representam carrinhos abandonados em um serviço de comércio eletrônico externo, como o Shopify. A API permite criar recursos de carrinho abandonados. Antes de criar carrinhos abandonados, você deve ter criado um recurso de conexão para o serviço de comércio eletrônico e um recurso do cliente para o cliente que abandonou o carrinho.

O carrinho de abandono de início de automação será acionado apenas se a origem do pedido de comércio eletrônico for de um webhook em tempo real, ecomOrder.source = 1. Para obter mais informações, leia [este artigo](https://help.activecampaign.com/hc/en-us/articles/360001046024-How-do-I-create-an-abandoned-cart-automation-Deep-Data-integration-).

Para criar um carrinho abandonado, use a mesma API que a criação de um pedido, mas em vez de incluir um externalid, inclua externalcheckoutid e abandoned_date.

Para marcar um carrinho abandonado existente como recuperado, atualize o carrinho existente e inclua um externalid.

### Criar um carrinho abandonado:
 ##### - POST https://youraccountname.api-us1.com/api/3/ecomOrders
Cria um carrinho abandonado
Parâmetros obrigatórios: ecomOrder.externalcheckoutid (string) | ecomOrder.email (string) | ecomOrder.orderProducts.name (string) | ecomOrder.orderProducts.price (int32) | ecomOrder.orderProducts.quantity (int32) | ecomOrder.totalPrice (int32) | ecomOrder.currency (int32) | ecomOrder.connectionid (int32) | ecomOrder.customerid (int32) | ecomOrder.orderDate (date) | ecomOrder.abandoned_date (date)
### JSON
```
{
  "ecomOrder": {
    "externalcheckoutid": "7777",
    "source": "1",
    "email": "andmferraz12@gmail.com",
    "orderProducts": [
      {
        "externalid": "PROD12345",
        "name": "Produto 1",
        "price": 4900,
        "quantity": 1,
        "category": "Toys",
        "sku": "POGO-12",
        "description": "lorem ipsum...",
        "imageUrl": "https://example.com/product.jpg",
        "productUrl": "https://store.example.com/product12345"
      },
      {
        "externalid": "PROD23456",
        "name": "Produto 2",
        "price": 3000,
        "quantity": 1,
        "category": "Aneis",
        "sku": "SK8BOARD145",
        "description": "lorem ipsum...",
        "imageUrl": "https://example.com/product.jpg",
        "productUrl": "https://store.example.com/product45678"
      }
    ],
    "orderUrl": "https://example.com/orders/3246315233",
    "externalCreatedDate": "2019-09-06T16:03:00-03:00",
    "externalUpdatedDate": "2019-09-06T16:03:00-03:00",
    "shippingMethod": "UPS Ground",
    "totalPrice": 9111,
    "shippingAmount": 200,
    "taxAmount": 500,
    "discountAmount": 100,
    "currency": "R$",
    "connectionid": "2",
    "customerid": "291",
	"abandoned_date": "2019-09-06T16:03:00-03:00"
  }
}
```
#### Observação:
Note que na criação do carrinho, as duas únicas alterações foram a inclusão do "externalcheckoutid", que seria um id gerado pelo e-commerce para o carrinho abandonado e a "abandoned_date", referente à data em que o carrinho foi abandonado.

## Produtos para pedidos do E-commerce
Os recursos do produto representam uma combinação de itens de linha e produtos em um serviço de comércio eletrônico externo, como o Shopify. A API permite consultar esses recursos, mas para criá-los, você deve criá-los como parte de um pedido.
### Listar itens de produtos:
 ##### - GET https://youraccountname.api-us1.com/api/3/ecomOrderProducts
Lista itens de produtos
### Listar itens de produtos de uma ordem específica:
 ##### - GET https://youraccountname.api-us1.com/api/3/ecomOrders/ecomOrderId/orderProducts
Lista itens de produtos de uma ordem específica
### Listar produto de uma ordem específica:
 ##### - GET https://youraccountname.api-us1.com/api/3/ecomOrderProducts/ecomOrderProductId
Lista produto de uma ordem específica
 ## Autor
* **Anderson Macário Ferraz**

