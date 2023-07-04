const db = require("../custom_modules/dbConnect");

class Category {
  static async getAll() {
    return new Promise((resolve, reject) => {
      db.query(`select * from Categories`, (error, results) => {
        if (error) reject(error);
        else resolve(results);
      });
    });
  }

  static async getSearchCount(searchVal) {
    return new Promise((resolve, reject) => {
      db.query(`select count(*) count from Categories cat left join categories cat1 on cat.parentID = cat1.id where cat.id like '${searchVal}' or cat.name like '${searchVal}%' or cat1.name like '${searchVal}%'`, (error, result) => {
        if (error) reject(error);
        else resolve(result[0].count);
      });
    });
  }

  static async searchRecords(searchVal, limit, offset) {
    return new Promise((resolve, reject) => {
      db.query(`select cat.id, cat.name name, cat1.name parentName from Categories cat left join categories cat1 on cat.parentID = cat1.id where cat.id like '${searchVal}' or cat.name like '${searchVal}%' or cat1.name like '${searchVal}%' order by id asc limit ${offset}, ${limit}`, (error, results) => {
        if (error) reject(error);
        else resolve(results);
      });
    });
  }

  static async deleteRecord(id) {
    return new Promise((resolve, reject) => {
      db.query(`delete from Categories where id = ${id}`, (error, result) => {
        if (error) reject(error);
        else {
          resolve(result);
        }
      });
    });
  }

  static async updateRecord(id, name, parentID) {
    return new Promise((resolve, reject) => {
      db.query(`update Categories set name = '${name}', parentID = ${parentID} where id = ${id}`, (error, result) => {
        if (error) reject(error);
        else {
          resolve(result);
        }
      });
    });
  }
}

module.exports = { Category };
