"use client";
import ArticleFacet from "./ArticleFacet";

export default function ControllerFacet() {
  return (
    <ArticleFacet
      category="controller"
      selectionKey="controller"
      title="Controller"
      queryKey={["controllerArticles"]}
    />
  );
}
