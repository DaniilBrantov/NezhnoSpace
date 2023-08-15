<?php
session_start();
date_default_timezone_set("Europe/Moscow");
require_once( get_theme_file_path('processing.php') );
class CloudPayments {
    private $apiUrl;
    private $authorization;
    private $db;
  
    public function __construct(string $apiUrl) {
      $this->apiUrl = $apiUrl;
      $this->authorization = base64_encode(trim(CLOUD_PUBLIC_ID) . ':' . trim(CLOUD_SECRET_KEY));
      $this->db = new SafeMySQL();
    }
  
    public function checkPayStatusDB(): bool {
        $today = date('Y-m-d H:i:s');
        $status = $this->db->getOne("SELECT status FROM users WHERE id=?i", $_SESSION['id']);
        if ($status === 'Active') {
          return true;
        } else {
          if($update_status = $this->updatePayStatus()){
            return true;
          }else{
            return false;
          }
        }
    }
  
    public function findSubscriptions(): array {
      $data = ['accountId' => trim($_COOKIE['mail'])];
      $options = [
        'http' => [
          'header'  => "Content-type: application/json\r\n" . "Authorization: Basic " . $this->authorization,
          'method'  => 'POST',
          'content' => json_encode($data),
        ],
      ];
  
      $context  = stream_context_create($options);
      $response = file_get_contents($this->apiUrl, false, $context);
  
      if ($response !== false) {
        $subscriptions = json_decode($response, true);
  
        if (array_key_exists('Model', $subscriptions)) {
          return $subscriptions['Model'];
        } else {
          return [];
        }
      } else {
        return [];
      }
    }
    public function getPayData() {
      return $this->PayData();
    }
    private function updatePayStatus(): bool {
      $payData = $this->getPayData();
      if ($payData['status']) {
        $payData = $payData['msg'];
        $today = date('Y-m-d H:i:s');
        $this->db->query(
          "UPDATE users SET status = ?s, created_payment = ?s, payment_date = ?s, payment_method = ?s WHERE id = ?i",
          $payData['Status'],
          $today,
          $today,
          $payData['Id'],
          $_SESSION['id']
        );
        return true;
      }
      return false;
    }
  
    private function PayData(): array {
      $findSubscriptions = $this->findSubscriptions();
      if ($findSubscriptions !== false) {
        foreach ($findSubscriptions as $subscription) {
          if ($subscription['Status'] === 'Active' && $subscription['Email'] === $_COOKIE['mail']) {
            return [
              'status' => true,
              'msg' => $subscription
            ];
          }
        }
      }
      return [
        'status' => false,
        'msg' => 'Ошибка при выполнении запроса'
      ];
    }
}

 
?>