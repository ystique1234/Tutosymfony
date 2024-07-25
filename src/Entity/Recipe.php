<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use App\Validator\InappropriateWords;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Traits\Timestampable;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich; 


#[ORM\Entity(repositoryClass: RecipeRepository::class)]
#[ORM\Table(name: "recipes")]
#[UniqueEntity('title')]
#[Vich\Uploadable]
class Recipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Length(min : 10, max : 50)]
    // #[Assert\NotEqualTo(value: "Merde", message:"vous ne povez pas ecrire 'M******'comme titre")]
    #[InappropriateWords()]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank()]
    #[Assert\Length(min : 20)]
    // #[InappropriateWords()]   
        // si on ulise la seconde les autres mots qui sont l'inappropriateWords.php sot ecrasés
    #[InappropriateWords(listWords: ["putain","fuck"])]    
    private ?string $content = null;

   use Timestampable;


   // NOTE: This is not a mapped field of entity metadata, just a simple property.
   #[Vich\UploadableField(mapping: 'recipes', fileNameProperty: 'imageName', size: 'imageSize')]
   private ?File $imageFile = null;

   #[ORM\Column(length: 500,nullable: true)]
   private ?string $imageName = null;

   #[ORM\Column(nullable: true)]
   private ?int $imageSize = null;


   /**
    * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
    * of 'UploadedFile' is injected into this setter to trigger the update. If this
    * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
    * must be able to accept an instance of 'File' as the bundle will inject one here
    * during Doctrine hydration.
    *
    * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
    */
   public function setImageFile(?File $imageFile = null): void
   {
       $this->imageFile = $imageFile;

       if (null !== $imageFile) {
           // It is required that at least one field changes if you are using doctrine
           // otherwise the event listeners won't be called and the file is lost
           $this->updatedAt = new \DateTimeImmutable();
       }
   }

   public function getImageFile(): ?File
   {
       return $this->imageFile;
   }

   public function setImageName(?string $imageName): void
   {
       $this->imageName = $imageName;
   }

   public function getImageName(): ?string
   {
       return $this->imageName;
   }

   public function setImageSize(?int $imageSize): void
   {
       $this->imageSize = $imageSize;
   }

   public function getImageSize(): ?int
   {
       return $this->imageSize;
   }
   
    #[ORM\Column(nullable: true)]
    #[Assert\Positive()]
    #[Assert\LessThan(value: 1440)]
    private ?int $duration = null;

    // #[ORM\Column(length: 500, nullable: true)]
    // private ?string $imageName = 
    // "https://upload.wikimedia.org/wikipedia/commons/a/ac/No_image_available.svg";

    #[ORM\ManyToOne(inversedBy: 'recipes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

   

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    // public function getImageName(): ?string
    // {
    //     return $this->imageName;
    // }

    // public function setImageName(?string $imageName): static
    // {
    //     $this->imageName = $imageName;

    //     return $this;
    // }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    
}
