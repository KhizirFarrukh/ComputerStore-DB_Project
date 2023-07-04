const db = require("../custom_modules/dbConnect");

class Product {
    static async getSearchCount(searchVal) {
        return new Promise((resolve, reject) => {
            db.query(`select count(*) count from ProductDetails`, (error, result) => {
                if (error)
                    reject(error);
                else resolve(result[0].count);
            });
        });
    }

    static async searchRecords(searchVal, limit, offset) {
        return new Promise((resolve, reject) => {
            db.query(`select * from ProductDetails where id like '${searchVal}%' or upc like '${searchVal}%' or sku like '${searchVal}%' or name like '${searchVal}%' or brandName like '${searchVal}%' or categoryName like '${searchVal}%' limit ${offset}, ${limit}`, (error, results) => {
                if (error) reject(error);
                else resolve(results);
            });
        });
    }

    static async deleteRecord(id) {
        return new Promise((resolve, reject) => {
            db.query(`delete from Products where id = ${id}`, (error, result) => {
                if (error) reject(error);
                else {
                    resolve(result);
                }
            });
        });
    }

    static async getImage(id) {
        return new Promise((resolve, reject) => {
            db.query(`select link from ProductDetails`, (error, results) => {
                if (error) reject(error);
                else resolve(results[0].link);
            });
        });
    }

    static async updateRecord(id, upc, sku, image, name, price, description, brand, category) {
        return new Promise((resolve, reject) => {
            db.query(`update Products set name = '${name}', price = ${price}, description = '${description}', brandID = ${brand}, categoryID = ${category} where id = ${id}`, (error, first) => {
                if (error) {
                    reject(error);
                } else {
                    db.query(`update ProductIdentifier set upc = '${upc}', sku = '${sku}' where id = ${id}`, first, (error, second) => {
                        if (error) {
                            reject(error);
                        } else {
                            db.query(`update ProductImages set link = case when '${image}'  != '' then '${image}' else link end where productID = ${id}`, { first, second }, (error, final) => {
                                if (error) {
                                    reject(error);
                                } else resolve({ first, second, final });
                            });
                        }
                    });
                }
            });
        });
    }
}

module.exports = { Product };