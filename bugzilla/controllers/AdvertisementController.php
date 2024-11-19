<?php
/**
 * AdvertisementController Class
 *
 * This class handles advert-related operations.
 */
class AdvertisementController
{
    /**
     * @var AdvertisementService $advertisementService The instance of AdvertisementService used for advert-related operations.
     */
    private $advertisementService;

    /**
     * Constructor to initialize AdvertisementController with AdvertisementService dependency.
     *
     * @param AdvertisementService $advertisementService The AdvertisementService instance.
     */
    public function __construct(AdvertisementService $advertisementService)
    {
        $this->advertisementService = $advertisementService;
    }

    /**
     * Fetches advertisements from AdvertisementService and renders the advertisement list view.
     */
    public function listAdvertisements()
    {
        try {
            // Fetch advertisements from the AdvertisementService
            $ads = $this->advertisementService->getAllAdvertisements();

            // Load the view with the fetched advertisements data
            require '../views/advertisementList.php';

        } catch (PDOException $e) {
            // Handle PDOException (database connection or query error)
            echo 'Database error: ' . $e->getMessage();
        } catch (Exception $e) {
            // Handle other exceptions (e.g., service method error)
            echo 'Error: ' . $e->getMessage();
        }
    }
}