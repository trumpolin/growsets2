import type { NextConfig } from "next";
import { execSync } from "node:child_process";

const isProd = process.env.NODE_ENV === "production";

let buildId = "dev";
try {
  buildId = execSync("git log -1 --format=%H -- frontend")
    .toString()
    .trim();
} catch {
  // ignore and use fallback id
}

const nextConfig: NextConfig = {
  output: "export",
  assetPrefix: isProd ? "./" : undefined,
  images: { unoptimized: true },
  generateBuildId: async () => buildId,
};

export default nextConfig;
