Feature: Cart clear
  In order to have empty cart
  A a customer
  I need to be able to clear cart

  Scenario: Cart clear
    Given there is "Laptop" product in customer cart
    When customer clear his cart
    Then customer cart should be empty
