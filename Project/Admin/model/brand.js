const db = require("../custom_modules/dbConnect");

class Brand {
  #id;
  #logo;
  #name;

  constructor(id, logo, name) {
    this.#id = id;
    this.#logo = logo;
    this.#name = name;
  }

  setID = (id) => {
    this.#id = id;
  };
  setLogo = (logo) => {
    this.#logo = logo;
  };
  setName = (name) => {
    this.#name = name;
  };
  getID = () => {
    return this.#id;
  };
  getLogo = () => {
    return this.#logo;
  };
  getName = () => {
    return this.#name;
  };

  static async updateRecord(id, name, logo) {
    return new Promise((resolve, reject) => {
      db.query(`update Brands set name='${name}', logo = case when '${logo}'  != '' then '${logo}' else logo end where id = ${id}`, (error, result) => {
        if (error) {
          reject(error);
        } else {
          resolve(result);
        }
      });
    });
  }

  static async deleteRecord(id) {
    return new Promise((resolve, reject) => {
      db.query(`delete from Brands where id = ${id}`, (error, result) => {
        if (error) reject(error);
        else {
          resolve(result);
        }
      });
    });
  }

  static async getSearchCount(searchVal) {
    return new Promise((resolve, reject) => {
      db.query(`select count(*) count from Brands where id like '%${searchVal}%' or name like '%${searchVal}%'`, (error, result) => {
        if (error) reject(error);
        else {
          resolve(result[0].count);
        }
      });
    });
  }

  static async getAll() {
    return new Promise((resolve, reject) => {
      db.query(`select * from Brands`, (error, results) => {
        if (error) reject(error);
        else {
          resolve(results);
        }
      });
    });
  }

  static async searchRecords(searchVal, limit, offset) {
    return new Promise((resolve, reject) => {
      db.query(`select * from Brands where id like '%${searchVal}%' or name like '%${searchVal}%' order by id asc limit ${offset}, ${limit}`, (error, results) => {
        if (error) reject(error);
        else resolve(results);
      });
    });
  }

  static async findByID(id) {
    return new Promise((resolve, reject) => {
      db.query(`select * from Brands where id = ${id}`, (error, results) => {
        if (error) reject(error);
        else return resolve(results);
      });
    });
  }

  static async getLogo(id) {
    return new Promise((resolve, reject) => {
      db.query(`select logo from Brands where id = ${id}`, (error, results) => {
        if (error) reject(error);
        else return resolve(results[0].logo);
      });
    });
  }

  static async findByName(name) {
    return new Promise((resolve, reject) => {
      db.query(`select * from Brands where name = ${name}`, (error, results) => {
        if (error) reject(error);
        else return resolve(results);
      });
    });
  }

  static async searchByName(name) {
    return new Promise((resolve, reject) => {
      db.query(`select * from Brands where name LIKE %${name}%`, (error, results) => {
        if (error) reject(error);
        else return resolve(results);
      });
    });
  }
}

module.exports = { Brand };
