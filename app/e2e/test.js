module.exports = {
  "Test Roster": function (browser) {
    browser
      .url("http://localhost:8080")
      .waitForElementVisible('body', 1000)
      .pause(10)
      .assert.containsText('body', 'New York')
      .end();
  }
};