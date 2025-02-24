# 🚀 Laravel SaaS com Serviços Modulares

## 📌 Sobre o Projeto
Este projeto é uma aplicação SaaS (Software como Serviço) desenvolvida em **Laravel**, onde cada funcionalidade pode ser implementada como um serviço modular, funcionando de forma independente dentro da aplicação. Os serviços são organizados em um diretório específico (`services/`), permitindo fácil manutenção, adição e remoção.

## 🏗️ Estrutura do Projeto

```
myapp/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
├── routes/
├── services/  <-- Diretório de Serviços Modulares
│   ├── Calculator/
│   │   ├── service.json
│   │   ├── CalculatorService.php
│   │   ├── CalculatorServiceProvider.php
│   │   ├── routes.php
│   │   ├── views/
├── storage/
└── tests/
```

Cada serviço é um módulo independente e contém:
- `service.json` → Metadados do serviço (ex: nome, descrição, preço).
- `CalculatorService.php` → Lógica principal do serviço.
- `CalculatorServiceProvider.php` → Provedor de serviço para registrar o módulo no Laravel.
- `routes.php` → Arquivo de rotas específicas do serviço.
- `views/` → Arquivos Blade para renderização do serviço.

## 🔌 Como Adicionar um Novo Serviço

Para adicionar um novo serviço:

1. Crie uma pasta dentro de `services/` com o nome do serviço.
2. Adicione os seguintes arquivos mínimos:
   - `service.json` → Contendo informações sobre o serviço.
   - `ServiceProvider.php` → Para registrar o serviço no Laravel.
   - `routes.php` → Se houver rotas específicas para o serviço.
   - `views/` → Templates para exibição do serviço (opcional).

### Exemplo de `service.json`:
```json
{
    "name": "Calculadora",
    "slug": "calculator",
    "description": "Um serviço para cálculos matemáticos.",
    "price": 9.99
}
```

### Exemplo de `routes.php`:
```php
use Illuminate\Support\Facades\Route;
use Services\Calculator\Controllers\CalculatorController;

Route::prefix('calculator')->group(function () {
    Route::get('/', [CalculatorController::class, 'index']);
    Route::post('/calculate', [CalculatorController::class, 'calculate']);
});
```

## ⚙️ Registro Automático de Serviços

Para evitar a necessidade de registrar cada serviço manualmente, o **`AppServiceProvider.php`** inclui um código que detecta e registra automaticamente todos os provedores de serviço dentro do diretório `services/`:

```php
use Illuminate\Support\Facades\File;

foreach (File::directories(base_path('services')) as $serviceDir) {
    $serviceName = basename($serviceDir);
    $providerClass = "Services\\{$serviceName}\\{$serviceName}ServiceProvider";
    
    if (class_exists($providerClass)) {
        $this->app->register($providerClass);
    }
}
```

## 🚀 Como Rodar o Projeto

1. **Clone o repositório**
   ```sh
   git clone https://github.com/seu-usuario/seu-projeto.git
   cd seu-projeto
   ```

2. **Instale as dependências**
   ```sh
   composer install
   npm install
   ```

3. **Configure o ambiente**
   - Copie `.env.example` para `.env` e configure banco de dados e outras variáveis.
   ```sh
   cp .env.example .env
   php artisan key:generate
   ```

4. **Execute as migrações**
   ```sh
   php artisan migrate
   ```

5. **Execute o servidor**
   ```sh
   php artisan serve
   ```

Agora sua aplicação Laravel SaaS com serviços modulares estará rodando! 🚀

---

## 📜 Licença
Este projeto é open-source e pode ser modificado conforme necessário. 🛠️

