### Laravel API + Vue SPA

Properties and contracts API playground. 

- Laravel 5.8
- Bootstrap 4
- Vue 2 + Vuex 

#### Backend Features

- RESTful API
- Form requests
- API resources
- Soft deletes
- Document validation: CPF, CNPJ (Brazil)


#### Frontend features

- State management
- Vue mixins (form component)
- Axios service layer
- Translations (i18n)
- Automatic form validation with Bootstrap
- Document validations integrated with backend
- Error handler
- Table sorting


#### Install

Install project PHP dependencies:

```
composer install
```

Rename `.env-example` to `.env` and configure (database...)

Run migrations and seeds:

```
php artisan migrate --seed
```
Run server:

```
php artisan serve
```

#### Endpoints

```
GET     api/cities                 cities.index
POST    api/contracts              contracts.store
GET     api/contracts/types        types.index
GET     api/countries              countries.index
GET     api/properties             properties.index
POST    api/properties             properties.store
DELETE  api/properties/{property}  properties.destroy
GET     api/states                 states.index
```

#### Tests

```
php vendor/bin/phpunit
```
