const customerModel = require("../model/customer.js").Customer;

const unkownError = (res) => {
  res.render("404.ejs", { eCode: 503, eHeading: "OOPS", eText: "Service Unavailable", eDesc: "Try again later." });
};

const notFound = (res) => {
  res.render("404.ejs", { eCode: 404, eHeading: "OOPS", eText: "Not Found!", eDesc: "(^_^)" });
};

const requestHandler = async (req, res) => {
  if (req == 0) {
    return await getRecordsCount(req, res);
  } else {
    displayRecords(req, res);
  }
};

const getRecordsCount = async (res) => {
  const count = await customerModel.getSearchCount("").catch((rejected) => {
    unkownError(res);
  });

  return count;
};

const displayRecords = async (req, res) => {
  const searchVal = req.query.searchVal == undefined ? "" : req.query.searchVal;
  const limit = 1;
  const queryCount = await customerModel.getSearchCount(searchVal).catch((rejected) => {
    unkownError(res);
  });

  let page = parseInt(req.query.page);
  if (page <= 0 || isNaN(page) || page > queryCount) {
    page = 1;
  }

  const offset = (page - 1) * limit;
  await customerModel
    .searchRecords(searchVal, limit, offset)
    .catch((rejected) => {
      unkownError(res);
    })
    .then((resolved) => {
      const pages = Math.ceil(queryCount / limit);
      if (page > pages) {
        res.render("customer.ejs", { customers: {}, searchVal: "", pagination: false, currentPage: 1, pageStart: 1, pageEnd: 0, maxPage: 1 }); //defaults
      } else {
        const pagination = pages > limit ? true : false;
        const pageStart = pagination ? offset * limit + 1 : 1;
        const pageEnd = pagination ? offset * limit + limit : pages;
        res.render("customer.ejs", { customers: resolved, searchVal: searchVal, pagination: pagination, currentPage: page, pageStart: pageStart, pageEnd: pageEnd, maxPage: pages });
      }
    });
};

module.exports = { requestHandler };
