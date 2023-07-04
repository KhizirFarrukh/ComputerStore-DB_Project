const express = require("express");
const router = express.Router();
const adminController = require("../controller/admin.js");
const multer = require("multer");
const path = require("path");

const brand_logoStorage = multer.diskStorage({
  destination: (req, file, callback) => {
    callback(null, "./public/images/logo");
  },
  filename: (req, file, callback) => {
    callback(null, req.body.brandName.toLowerCase() + path.extname(file.originalname));
  },
});

const product_imageStorage = multer.diskStorage({
  destination: (req, file, callback) => {
    callback(null, "./public/images/products");
  },
  filename: (req, file, callback) => {
    callback(null, req.body.name.toLowerCase() + path.extname(file.originalname));
  },
});

const brand_logoUpload = multer({ storage: brand_logoStorage }).single("brandLogo");
const product_imageUpload = multer({ storage: product_imageStorage }).single("image");

router.get("/dashboard", adminController.dashboard);

router.get("/dashboard/brands", adminController.brands);
router.post("/dashboard/brands", adminController.brands);
router.post("/dashboard/brands/update", brand_logoUpload, adminController.brands);

router.get("/dashboard/customers", adminController.customers);

router.get("/dashboard/categories", adminController.categories);
router.post("/dashboard/categories", adminController.categories);

router.get("/dashboard/products", adminController.products);
router.post("/dashboard/products", adminController.products);
router.post("/dashboard/products/update", product_imageUpload, adminController.products);

module.exports = router;
