<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class FileStorageService
{
    /**
     * Save a base64 file to the specified path and optionally delete the old file.
     */
    public function saveBase64File(string $file, string $path, ?string $oldFilePath = null): string
    {
        if ($oldFilePath && Storage::disk('public')->exists($oldFilePath)) {
            $this->deleteFile($oldFilePath);
        }

        if (!$this->isValidBase64($file)) {
            throw new \InvalidArgumentException('Invalid Base64 string provided.');
        }

        $content = $this->decodeBase64File($file);
        $extension = $this->getBase64FileExtension($file);
        $fileName = $this->generateUniqueFileName($extension);

        $filePath = "{$path}/{$fileName}";
        Storage::disk('public')->put($filePath, $content);

        return $filePath;
    }

    public function saveFile($file, $path): string
    {
        // Gerar um nome único para o arquivo
        $fileName = $this->generateUniqueFileName($file->getClientOriginalExtension());

        // Criar o caminho completo do arquivo (pasta + nome do arquivo)
        $filePath = "{$path}/{$fileName}";

        // Salvar o arquivo na pasta 'public' usando o sistema de arquivos do Laravel
        Storage::disk('public')->put($filePath, file_get_contents($file));

        return $filePath;
    }


    /**
     * Decode a base64 encoded file.
     */
    private function decodeBase64File(string $file): string
    {
        $fileContent = preg_replace('#^data:image/[^;]+;base64,#', '', $file);
        $decodedContent = base64_decode($fileContent);

        if ($decodedContent === false) {
            throw new \RuntimeException('Failed to decode Base64 string.');
        }

        return $decodedContent;
    }

    /**
     * Extract the file extension from a base64 encoded file.
     */
    public function getBase64FileExtension(string $file): string
    {
        preg_match('#^data:image/([^;]+);base64,#', $file, $matches);
        return $matches[1] ?? 'png'; // Default to 'png' if not detected.
    }

    /**
     * Validate if a string is a valid Base64 encoded string.
     */
    private function isValidBase64(string $file): bool
    {
        return preg_match('#^data:image/[^;]+;base64,[A-Za-z0-9+/=]+$#', $file);
    }

    public function isBase64(string $string): bool
    {
        return preg_match('/^data:image\/(\w+);base64,/', $string);
    }

    /**
     * Generate a unique file name with the given extension.
     */
    private function generateUniqueFileName(string $extension): string
    {
        return md5(uniqid(microtime(), true)) . ".{$extension}";
    }

    /**
     * Delete a file if it exists.
     */
    public function deleteFile(string $filePath): void
    {
        Storage::disk('public')->delete($filePath);
    }

    /**
     * Get the public URL of a file.
     */
    public function getFileUrl(string $path): ?string
    {
        return Storage::disk('public')->exists($path) ? Storage::url($path) : null;
    }
}
