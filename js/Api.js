// import Urls from '/services/urls';

const Api = class {
  static headers() {
    return {
      'Accept': 'application/json',
      mode: 'no-cors',
      'Content-Type': 'application/x-www-form-urlencoded',
      'Authorization': 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6ImpxcW5tNzl4IiwidXNlcm5hbWUiOiJhZG1pbjE3Iiwicm9sZSI6IkFkbWluIiwiUm9sZUlkIjoiam1rdDQxb3QiLCJpYXQiOjE1NDcyNzg5NDl9.DT3jOw3FPk30noGIpjs0A19l5qWZxEj3rVugUjfT15w',
    }
  }

  static get(route) {
    return this.xhr(route, null, 'GET');
  }

  static post(route, params) {
    return this.xhr(route, params, 'POST');
  }

  static put(route, params) {
    return this.xhr(route, params, 'PUT');
  }

  static delete(route, params) {
    return this.xhr(route, params, 'DELETE');
  }

  static xhr(route, params, verb) {
    const url = `${route}`;
    
    let options = Object.assign({
      method: verb
    }, params ? { body: JSON.stringify(params) } : null);
    
    options.headers = Api.headers();
    
    return fetch(url, options).then(response => {
      let json = response.json();
      if (response.ok) {
        return json;
      }else{
        return json.then(err => {
          throw err
        });
      }
    })
  }
}