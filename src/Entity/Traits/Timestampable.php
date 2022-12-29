<?php

    namespace App\Entity\Traits;


    use Doctrine\ORM\Mapping as ORM;

    trait Timestampable
    {
        #[ORM\Column(options:["default" => "CURRENT_TIMESTAMP"])]
        private ?\DateTimeImmutable $createdAt = null;
    
        #[ORM\Column(options:["default" => "CURRENT_TIMESTAMP"])]
        private ?\DateTimeImmutable $updatedAt = null;

        public function getCreatedAt(): ?\DateTimeImmutable
        {
            return $this->createdAt;
        }

        public function setCreatedAt(\DateTimeImmutable $createdAt): self
        {
            $this->createdAt = $createdAt;

            return $this;
        }

        public function getUpdatedAt(): ?\DateTimeImmutable
        {
            return $this->updatedAt;
        }

        public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
        {
            $this->updatedAt = $updatedAt;

            return $this;
        }

        #[ORM\PrePersist]
        #[ORM\PreUpdate]
        public function updateTimestamp( )
        {
            if ($this->getCreatedAt() === null)
            {
                $this->setCreatedAt(new \DateTimeImmutable());
            }
            $this->setUpdatedAt(new \DateTimeImmutable());
        }
    
        
    }