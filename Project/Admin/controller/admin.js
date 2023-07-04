const adminModel = require("../model/brand.js");
const brandController = require("./brand.js");
const customerController = require("./customer.js");
const categoryController = require("./category.js");
const productController = require("./product.js");

const dashboard = async (req, res) => {
  res.render("dashboard.ejs", {
    brandCount: await brandController.requestHandler(0, res),
    customerCount: await customerController.requestHandler(0, res),
    categoryCount: await categoryController.requestHandler(0, res),
    productCount: await productController.requestHandler(0, res),
  });
};

const orders = (req, res) => {
  res.render("orders.ejs");
};

const brands = (req, res) => {
  brandController.requestHandler(req, res);
};

const customers = (req, res) => {
  customerController.requestHandler(req, res);
};

const categories = (req, res) => {
  categoryController.requestHandler(req, res);
};

const products = (req, res) => {
  productController.requestHandler(req, res);
};

module.exports = { dashboard, orders, brands, customers, categories, products };
