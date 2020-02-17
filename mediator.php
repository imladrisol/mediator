<?php

interface Mediator
{
    public function notify(object $sender, string $event): void;
}

class ConcreteMediator implements Mediator
{
    private $concierge;

    private $user;

    public function __construct(Concierge $concierge, User $user)
    {
        $this->concierge = $concierge;
        $this->concierge->setMediator($this);
        $this->user = $user;
        $this->user->setMediator($this);
    }

    public function notify(object $sender, string $event): void
    {
        if ($event == 'CallTaxi') {
            echo "Mediator reacts on call taxi and triggers following operations:\n";
            $this->concierge->doCallTaxi();
        } else if ($event == 'BuyFlowers') {
            echo "Mediator reacts on buy flowers and triggers following operations:\n";
            $this->concierge->doBuyFlowers();
        } else if ($event == 'CallMaster') {
            echo "Mediator reacts on call master and triggers following operations:\n";
            $this->concierge->doCallMaster();
        }
    }
}

class BaseComponent
{
    protected $mediator;

    public function __construct(Mediator $mediator = null)
    {
        $this->mediator = $mediator;
    }

    public function setMediator(Mediator $mediator): void
    {
        $this->mediator = $mediator;
    }
}

class Concierge extends BaseComponent
{
    public function doCallTaxi(): void
    {
        echo "Concierge cal taxi.\n";
    }

    public function doBuyFlowers(): void
    {
        echo "Concierge does buy flowers.\n";
    }

    public function doCallMaster(): void
    {
        echo "Concierge does call master.\n";
    }
}

class User extends BaseComponent
{
    public function doCallTaxi(): void
    {
        $this->mediator->notify($this, "CallTaxi");
    }

    public function doBuyFlowers(): void
    {
        $this->mediator->notify($this, "BuyFlowers");
    }

    public function doCallMaster(): void
    {
        $this->mediator->notify($this, "CallMaster");
    }
}


$concierge = new Concierge;
$user = new User;
$mediator = new ConcreteMediator($concierge, $user);

echo "User triggers call taxi.\n";
$user->doCallTaxi();

echo "****************\nUser triggers buy flowers.\n";
$user->doBuyFlowers();


echo "****************\nUser triggers call master.\n";
$user->doCallMaster();
