<?php

namespace App\Entity;

use App\Repository\FilmRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FilmRepository::class)]
#[ORM\Table(name: 'films', indexes: [new ORM\Index(name: 'is_promo_idx', columns: ['isPromo'])])]
class Film
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['film:list', 'film:detail'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['film:list', 'film:detail'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $released = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['film:detail'])]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $runTime = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 3, scale: 1, nullable: true)]
    private ?string $rating = null;

    #[ORM\Column(nullable: true)]
    private ?int $imdbVotes = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imdbId = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $posterImage = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $previewImage = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $backgroundImage = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $backgroundColor = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $videoLink = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $previewVideoLink = null;

    #[ORM\Column(options: ['default' => false])]
    private ?bool $isPromo = false;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?DateTimeImmutable $updatedAt = null;

    public const PAGINATION_LIMIT = 8;

    #[ORM\ManyToMany(targetEntity: Genre::class, inversedBy: "films")]
    #[ORM\JoinTable(name: 'film_genre')]
    private Collection $genres;

    #[ORM\ManyToMany(targetEntity: Actor::class, inversedBy: "films")]
    #[ORM\JoinTable(name: 'film_actor')]
    private Collection $actors;

    #[ORM\ManyToMany(targetEntity: Director::class, inversedBy: "films")]
    #[ORM\JoinTable(name: 'film_director')]
    private Collection $directors;

    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: "film", cascade: ["remove"])]
    private Collection $comments;

    /**
     * @var Collection<int, FavoriteFilm>
     */
    #[ORM\OneToMany(targetEntity: FavoriteFilm::class, mappedBy: 'film')]
    private Collection $favoriteFilms;

    public function __construct()
    {
        $this->createdAt =
            new DateTimeImmutable();
        $this->genres =
            new ArrayCollection();
        $this->actors =
            new ArrayCollection();
        $this->directors =
            new ArrayCollection();
        $this->comments =
            new ArrayCollection();
        $this->favoriteFilms =
            new ArrayCollection();
    }

    public function getId() : ?int
    {
        return $this->id;
    }

    public function getName() : ?string
    {
        return $this->name;
    }

    public function setName(?string $name) : static
    {
        $this->name =
            $name;

        return $this;
    }

    public function getStatus() : ?string
    {
        return $this->status;
    }

    public function setStatus(string $status) : static
    {
        $this->status =
            $status;

        return $this;
    }

    public function getReleased() : ?string
    {
        return $this->released;
    }

    public function setReleased(?string $released) : static
    {
        $this->released =
            $released;

        return $this;
    }

    public function getDescription() : ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description) : static
    {
        $this->description =
            $description;

        return $this;
    }

    public function getRunTime() : ?string
    {
        return $this->runTime;
    }

    public function setRunTime(?string $runTime) : static
    {
        $this->runTime =
            $runTime;

        return $this;
    }

    public function getRating() : ?string
    {
        return $this->rating;
    }

    public function setRating(?string $rating) : static
    {
        $this->rating =
            $rating;

        return $this;
    }

    public function getImdbVotes() : ?int
    {
        return $this->imdbVotes;
    }

    public function setImdbVotes(?int $imdbVotes) : static
    {
        $this->imdbVotes =
            $imdbVotes;

        return $this;
    }

    public function getImdbId() : ?string
    {
        return $this->imdbId;
    }

    public function setImdbId(?string $imdbId) : static
    {
        $this->imdbId =
            $imdbId;

        return $this;
    }

    public function getPosterImage() : ?string
    {
        return $this->posterImage;
    }

    public function setPosterImage(?string $posterImage) : static
    {
        $this->posterImage =
            $posterImage;

        return $this;
    }

    public function getPreviewImage() : ?string
    {
        return $this->previewImage;
    }

    public function setPreviewImage(?string $previewImage) : static
    {
        $this->previewImage =
            $previewImage;

        return $this;
    }

    public function getBackgroundImage() : ?string
    {
        return $this->backgroundImage;
    }

    public function setBackgroundImage(?string $backgroundImage) : static
    {
        $this->backgroundImage =
            $backgroundImage;

        return $this;
    }

    public function getBackgroundColor() : ?string
    {
        return $this->backgroundColor;
    }

    public function setBackgroundColor(?string $backgroundColor) : static
    {
        $this->backgroundColor =
            $backgroundColor;

        return $this;
    }

    public function getVideoLink() : ?string
    {
        return $this->videoLink;
    }

    public function setVideoLink(?string $videoLink) : static
    {
        $this->videoLink =
            $videoLink;

        return $this;
    }

    public function getPreviewVideoLink() : ?string
    {
        return $this->previewVideoLink;
    }

    public function setPreviewVideoLink(?string $previewVideoLink) : static
    {
        $this->previewVideoLink =
            $previewVideoLink;

        return $this;
    }

    public function getIsPromo() : ?bool
    {
        return $this->isPromo;
    }

    public function setIsPromo(bool $isPromo) : static
    {
        $this->isPromo =
            $isPromo;

        return $this;
    }

    /**
     * @return Collection<int, FavoriteFilm>
     */
    public function getFavoriteFilms() : Collection
    {
        return $this->favoriteFilms;
    }

    public function addFavoriteFilm(FavoriteFilm $favoriteFilm) : static
    {
        if (!$this->favoriteFilms->contains($favoriteFilm)) {
            $this->favoriteFilms->add($favoriteFilm);
            $favoriteFilm->setFilm($this);
        }

        return $this;
    }

    public function removeFavoriteFilm(FavoriteFilm $favoriteFilm) : static
    {
        if ($this->favoriteFilms->removeElement($favoriteFilm)) {
            if ($favoriteFilm->getFilm() === $this) {
                $favoriteFilm->setFilm(null);
            }
        }

        return $this;
    }

    public function getGenres() : Collection
    {
        return $this->genres;
    }

    public function addGenre(Genre $genre) : self
    {
        if (!$this->genres->contains($genre)) {
            $this->genres->add($genre);
            $genre->addFilm($this);
        }

        return $this;
    }

    public function removeGenre(Genre $genre) : self
    {
        if ($this->genres->removeElement($genre)) {
            $genre->removeFilm($this);
        }

        return $this;
    }

    public function getActors() : Collection
    {
        return $this->actors;
    }

    public function addActor(Actor $actor) : self
    {
        if (!$this->actors->contains($actor)) {
            $this->actors->add($actor);
            $actor->addFilm($this);
        }

        return $this;
    }

    public function removeActor(Actor $actor) : self
    {
        if ($this->actors->removeElement($actor)) {
            $actor->removeFilm($this);
        }

        return $this;
    }

    public function getDirectors() : Collection
    {
        return $this->directors;
    }

    public function addDirector(Director $director) : self
    {
        if (!$this->directors->contains($director)) {
            $this->directors->add($director);
            $director->addFilm($this);
        }

        return $this;
    }

    public function removeDirector(Director $director) : self
    {
        if ($this->directors->removeElement($director)) {
            $director->removeFilm($this);
        }

        return $this;
    }
}
