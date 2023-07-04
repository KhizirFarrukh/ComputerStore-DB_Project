const db = require("../custom_modules/dbConnect");

class Customer {
  static async getSearchCount(searchVal) {
    return new Promise((resolve, reject) => {
      db.query(`select count(*) count from Customers cust left join CustomerAddress ca on cust.id = ca.id where cust.id like '%${searchVal}%' or cust.email like '${searchVal}%' or cust.phoneNumber like '${searchVal}%' or cust.firstName like '${searchVal}%' or cust.lastName like '${searchVal}%'`, (error, result) => {
        if (error) reject(error);
        else resolve(result[0].count);
      });
    });
  }

  static async searchRecords(searchVal, limit, offset) {
    return new Promise((resolve, reject) => {
      db.query(`select cust.id, cust.email, cust.firstName, cust.lastName, cust.phoneNumber, ca.addressLine, ca.state, ca.city, ca.zipCode from Customers cust left join CustomerAddress ca on cust.id = ca.id where cust.id like '%${searchVal}%' or cust.email like '${searchVal}%' or cust.phoneNumber like '${searchVal}%' or cust.firstName like '${searchVal}%' or cust.lastName like '${searchVal}%' order by id asc limit ${offset}, ${limit}`, (error, results) => {
        if (error) reject(error);
        else resolve(results);
      });
    });
  }
}

module.exports = { Customer };
