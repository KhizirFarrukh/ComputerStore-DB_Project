const productModel = require("../model/product.js").Product;
const fs = require("fs");
const brandController = require("./brand");
const categoryController = require("./category");

const unkownError = (res) => {
    res.render("404.ejs", { eCode: 503, eHeading: "OOPS", eText: "Service Unavailable", eDesc: "Try again later." });
};

const notFound = (res) => {
    res.render("404.ejs", { eCode: 404, eHeading: "OOPS", eText: "Not Found!", eDesc: "(^_^)" });
};

const requestHandler = async(req, res) => {
    if (req == 0) {
        return await getRecordsCount(res).catch((error) => {});
    } else if (req.body.status == -1) {
        deleteRecord(req, res);
    } else if (req.body.status == 0) {
        updateRecords(req, res);
    } else {
        displayRecords(req, res);
    }
};

const getRecordsCount = (res) => {
    const count = productModel.getSearchCount("").catch((rejected) => {
        return "Not Available";
    });

    return count;
};

const displayRecords = async(req, res) => {
    const searchVal = req.query.searchVal == undefined ? "" : req.query.searchVal;
    const limit = 1;
    const queryCount = await productModel.getSearchCount(searchVal).catch((rejected) => {
        unkownError(res);
    });

    let page = parseInt(req.query.page);
    if (page <= 0 || isNaN(page) || page > queryCount) {
        page = 1;
    }
    let allBrands;
    let allCategories;
    await brandController
        .requestHandler(1)
        .catch((rejected) => {
            allBrands = {};
        })
        .then((resolved) => {
            allBrands = resolved;
        });

    await categoryController
        .requestHandler(1)
        .catch((rejected) => {
            allCategories = {};
        })
        .then((resolved) => {
            allCategories = resolved;
        });

    const offset = (page - 1) * limit;
    await productModel
        .searchRecords(searchVal, limit, offset)
        .catch((rejected) => {
            unkownError(res);
            return;
        })
        .then((resolved) => {
            const pages = Math.ceil(queryCount / limit);
            if (page > pages) {
                res.render("product.ejs", { products: {}, brands: {}, categories: {}, pagination: false, currentPage: 1, pageStart: 1, pageEnd: 0, maxPage: 1 }); //defaults
            } else {
                const pagination = pages > limit ? true : false;
                const pageStart = pagination ? offset * limit + 1 : 1;
                const pageEnd = pagination ? offset * limit + limit : pages;
                res.render("product.ejs", { products: resolved, brands: allBrands, categories: allCategories, pagination: pagination, currentPage: page, pageStart: pageStart, pageEnd: pageEnd, maxPage: pages });
            }
        });
};

const deleteRecord = async(req, res) => {
    const id = parseInt(req.body.index);
    const response = await productModel.deleteRecord(id).catch((rejected) => {
        unkownError(res);
    });
    if (response.affectedRows == 1) {
        res.send(true);
    }
};

const updateRecords = async(req, res) => {
    const id = parseInt(req.body.index);
    const image = req.file == undefined ? "" : req.file.filename;
    const price = Number(req.body.price);
    if (image != "") {
        await productModel
            .getImage(id)
            .catch((rejected) => {
                console.log(rejected);
            })
            .then((resolved) => {
                fs.unlink(`./public/images/products/${resolved}`, (error) => {
                    console.log(error);
                });
            });
    }
    await productModel
        .updateRecord(id, req.body.upc, req.body.sku, image, req.body.name, price, req.body.description, req.body.brand, req.body.category)
        .catch((rejected) => {
            unkownError(res);
        })
        .then((resolved) => {
            console.log(resolved);
            res.send(true);
        });
};

module.exports = { requestHandler };