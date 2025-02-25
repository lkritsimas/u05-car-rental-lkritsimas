<?php

namespace CarRental\Controllers;

use CarRental\Exceptions\HTTPException;
use CarRental\Models\CustomerModel;
use CarRental\Models\BookingModel;

class CustomerController extends AbstractController
{
  public function get()
  {
    $customerModel = new CustomerModel($this->db);
    $bookingModel = new BookingModel($this->db);
    $customers = $customerModel->getCustomers();

    foreach ($customers as $key => $customer) {
      $bookingDetails = $bookingModel->getBookingDetails($customer['id']);
      $customers[$key]["editable"] = $bookingDetails["active"];
    }

    return $this->render("Customers.html.twig", [
      "route" => "customers",
      "customers" => $customers
    ]);
  }

  public function add()
  {
    $customerModel = new CustomerModel($this->db);
    $created = null;

    if ($this->request->getMethod() === "POST") {
      $data = $this->request->getData();

      if (empty($data))
        throw new HTTPException("No POST data was provided", 500);
      else if (empty($data["id"]) || empty($data["firstname"]) || empty($data["surname"]) || empty($data["address"]) || empty($data["postcode"]) || empty($data["city"]) || empty($data["phone"]))
        $created = false;
      else
        $created = $customerModel->addCustomer($data["id"], $data["firstname"], $data["surname"], $data["address"], $data["postcode"], $data["city"], $data["phone"]);
    }

    return $this->render("NewCustomer.html.twig", [
      "route" => "customers",
      "success" => $created,
      "responseMessage" => $created ? "Successfully created user" : "Could not create user"
    ]);
  }

  public function update($data)
  {
    $customerModel = new CustomerModel($this->db);
    $customerUpdated = null;

    // Update customer if request method is POST
    if ($this->request->getMethod() === "POST") {
      $data = $this->request->getData();

      if (empty($data))
        throw new HTTPException("No POST data was provided", 500);
      else
        $customerUpdated = $customerModel->updateCustomer($data["id"], $data["firstname"], $data["surname"], $data["address"], $data["postcode"], $data["city"], $data["phone"]);
    }

    $customer = $customerModel->getCustomer($data["id"]);

    return $this->render("EditCustomer.html.twig", [
      "route" => "customers",
      "success" => $customerUpdated,
      "customer" => $customer
    ]);
  }

  public function delete()
  {
    $data = $this->request->getData();

    $customerModel = new customerModel($this->db);
    $customerRemoved = $customerModel->removeCustomer($data["id"]);

    return json_encode(["success" => $customerRemoved]);
  }
}
