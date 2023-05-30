<?php
class UserAccount {
    private $personalInformation;
    private $address;
    private $contactInformation;
    private $bankAccount;
    private $bankAccountPlus;

    public function __construct(
        PersonalInformation $personalInformation,
        Address $address,
        ContactInformation $contactInformation
    ) {
        $this->personalInformation = $personalInformation;
        $this->address = $address;
        $this->contactInformation = $contactInformation;
    }

    public function createBankAccount(string $accountNumber, float $balance = 0): void {
        if (!$this->bankAccount) {
            $this->bankAccount = new BankAccount($accountNumber, $balance);
        }
    }

    public function createBankAccountPlus(string $accountNumber, float $balance = 0, float $penaltyInterest = 0.05): void {
        if ($this->bankAccount && !$this->bankAccountPlus) {
            $this->bankAccountPlus = new BankAccountPlus($accountNumber, $balance, $penaltyInterest);
        }
    }

}


class PersonalInformation {
    private $name;
    private $age;
}

class Address {
    private $street;
    private $city;
}

class ContactInformation {
    private $email;
    private $phoneNumber;
}

class BankAccount {
    private $accountNumber;
    private $balance;

    public function __construct(string $accountNumber, float $balance = 0) {
        $this->accountNumber = $accountNumber;
        $this->balance = $balance;
    }

    public function depositMoney(float $amount): void {
        $this->balance += $amount;
    }

    public function withdrawMoney(float $amount): void {
        if ($amount <= $this->balance) {
            $this->balance -= $amount;
        } else {
            echo "Insufficient balance.";
        }
    }
}

class BankAccountPlus extends BankAccount {
    private $limit = -1000;
    private $penaltyInterest;

    public function __construct(string $accountNumber, float $balance = 0, float $penaltyInterest = 0.05) {
        parent::__construct($accountNumber, $balance);
        $this->penaltyInterest = $penaltyInterest;
    }

    public function withdrawMoney(float $amount): void {
        $balanceWithPenalty = $this->balance - $amount;

        if ($balanceWithPenalty >= $this->limit) {
            $this->balance -= $amount;
        } else {
            echo "Insufficient balance including limit.";
        }
    }

    public function calculatePenaltyAmount(): float {
        if ($this->balance < 0) {
            $penaltyAmount = abs($this->balance) * $this->penaltyInterest;
            return $penaltyAmount;
        } else {
            return 0;
        }
    }

    public function showPenaltyBalanceDate(): void {
        $penaltyAmount = $this->calculatePenaltyAmount();
        $dateTime = date("Y-m-d H:i:s");
        echo "Penalty amount: $penaltyAmount, Balance: $this->balance, Date/Time: $dateTime";
    }
}


$BankAccount = new BankAccount("12345678", 1000);
$BankAccountPlus = new BankAccountPlus("87654321", 2000);
?>
